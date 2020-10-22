<?php

namespace App\Http\Controllers\Api\Wallet;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\CouponUser;
use App\Models\User;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function wallet_data()
    {
        $user = \request()->user();
        if ($user->type!='USER'){
            return response()->json(['message' => "Wrong credentials."], 401); // HTTP_UNAUTHORIZED
        }
        return response()->json(['wallet' => (int)$user->wallet], 200);
    }
    public function debit_data()
    {
        $user = \request()->user();
        if ($user->type!='TEACHER'){
            return response()->json(['message' => "Wrong credentials."], 401); // HTTP_UNAUTHORIZED
        }
        return response()->json(['debit' => (int)$user->center->debit], 200);
    }
    public function subscribe_qr(Request $request){
        $user = $request->user();
        if ($user->type!='USER'){
            return response()->json(['message' => "Wrong credentials."], 401); // HTTP_UNAUTHORIZED
        }
        $qr=$request['qr'];
        $qr_arr= explode("-",$qr);
        if (count($qr_arr)!=4){
            return response()->json(['message' => "فشلت العملية."], 400);
        }
        $expired_coupon=CouponUser::where('coupon_pattern',$qr)->first();
        if ($expired_coupon){
            return response()->json(['message' => "فشلت العملية."], 400);
        }
        $coupon_id = substr($qr_arr[2], 0, 2)/28;
        $teacher_id = substr($qr_arr[3], 4)/7;
        $teacher=User::where(['id'=>$teacher_id,'type'=>'TEACHER'])->first();
        $coupon=Coupon::where(['id'=>$coupon_id,'status'=>1])->first();
        if ($qr_arr[0]!="G" || !$teacher || !$coupon)
            return response()->json(['message' => "فشلت العملية."], 400);
        //charge wallet
        $updated_wallet_user=$user->wallet+$coupon->price;
        $updated_debit_teacher=$teacher->debit+$coupon->price;
        $updated_debit_center=$teacher->center->debit+$coupon->price;
        $user->update([
            'wallet'=>$updated_wallet_user
        ]);
        $teacher->update([
            'debit'=>$updated_debit_teacher
        ]);
        $teacher->center->update([
            'debit'=>$updated_debit_center
        ]);
        CouponUser::create([
           'user_id'=>$user->id,
           'teacher_id'=>$teacher->id,
           'coupon_id'=>$coupon->id,
           'coupon_pattern'=>$qr,
        ]);
        return response()->json(['message' => "تمت العملية بنجاح."], 200);
    }
}
