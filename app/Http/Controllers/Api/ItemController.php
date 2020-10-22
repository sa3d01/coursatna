<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ItemBuyCallbackRequest;
use App\Http\Requests\Api\ItemBuyRequest;
use App\Http\Requests\Api\ItemUploadRequest;
use App\Models\Item;
use App\Models\UserBoughtItem;
use App\Models\Transaction;
use App\Traits\MoneyOperations\MoneyChargerTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemsCollection;
use App\Http\Resources\Item as ItemResource;

class ItemController extends Controller
{
    use MoneyChargerTrait;

    public function index(Request $request)
    {
        $where = ['status' => 'APPROVED'];
        if ($request->has('type')) {
            $where['type'] = $request['type'];
        }
        if ($request->has('subject')) {
            $where['subject'] = $request['subject'];
        }
        if ($request->has('school_subject_id')) {
            $where['school_subject_id'] = $request['school_subject_id'];
        }
        if ($request->has('university_subject_id')) {
            $where['university_subject_id'] = $request['university_subject_id'];
        }

        $whereHasUniSubject = [];
        if ($request->has('faculty_id')) {
            $whereHasUniSubject['faculty_id'] = $request['faculty_id'];
        }
        if ($request->has('major_id')) {
            $whereHasUniSubject['major_id'] = $request['major_id'];
        }

        if ($request->has('name')) {
            return new ItemsCollection(Item::where($where)
                ->where('name', 'like', '%' . $request['name'] . '%')
                ->whereHas('universitySubject', function ($q) use ($whereHasUniSubject) {
                    $q->where($whereHasUniSubject);
                })
                ->paginate());
        } else {
            return new ItemsCollection(Item::where($where)->paginate());
        }
    }

    public function my()
    {
        $userId = auth()->id();
        return new ItemsCollection(Item::whereHas('buyers', function ($q) use ($userId) {
            $q->where('buyer_id', $userId);
        })->paginate());
    }

    public function show(Item $item)
    {
        return response()->json(new ItemResource($item), 200);
    }

    public function upload(ItemUploadRequest $request)
    {
        $data = $request->validated();
        $data['uploader_id'] = auth()->guard('api')->id();
        $data['status'] = 'PENDING_REVIEW';
        Item::create($data);
        return response()->json(['message' => 'Thanks. Your item is pending review.'], 201);
    }

    public function buy(ItemBuyRequest $request, Item $item)
    {
        $user = $request->user();
        if (UserBoughtItem::where([
            'buyer_id' => $user->id,
            'item_id' => $item->id,
        ])->first()) {
            return response()->json(['message' => 'You already own this item'], 400);
        }

        $account = $this->getUserMoneyAccount($user);
        if ($account->balance >= $item->price) {

            $this->addInternalTransaction($user, 'Item', $item->id, $item->price);

            $userBought = UserBoughtItem::create([
                'buyer_id' => $user->id,
                'item_id' => $item->id,
                'paid' => $item->price,
            ]);
            $account->update([
                'balance' => $account->balance - $userBought->paid,
            ]);
            return response()->json([
                'message' => 'Bought the item successfully for ' . $userBought->paid . ' EGP.',
            ], 201);
        }
        return response()->json([
            'message' => 'Sorry, You do not have enough balance to buy it',
        ], 400);
    }

    public function buyCallback(ItemBuyCallbackRequest $request)
    {
        if ($request['merchant_id'] != config('app.merchant_id')) {
            return response()->json(['message' => 'Wrong Merchant.'], 400);
        }

        $transaction = Transaction::where(['reference' => $request['reference']])->first();
        if (!$transaction) {
            return response()->json(['message' => 'Reference not found.'], 404);
        }

        if ($request['status'] == 'PAID') {
            $transaction->update(['paid_at' => Carbon::now()]);
            UserBoughtItem::create([
                'student_id' => $transaction['user_id'],
                'item_id' => $transaction['item_id'],
                'paid' => $transaction['amount'],
            ]);
        }
        if ($request['status'] == 'EXPIRED') {
            $transaction->update(['expired_at' => Carbon::now()]);
        }
        return response()->json(['message' => 'Updated Successfully.'], 202);
    }
}
