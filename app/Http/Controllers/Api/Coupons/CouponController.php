<?php


namespace App\Http\Controllers\Api\Coupons;

use App\Http\Resources\Coupon\NotificationDTO;
use App\Http\Resources\Coupon\CouponResource;
use App\Models\Coupon;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


class CouponController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if ($user->type!='TEACHER'){
            return response()->json(['message' => "Wrong credentials."], 401); // HTTP_UNAUTHORIZED
        }
        return NotificationDTO::collection(Coupon::paginate());
    }
    public function show($money){
        $user = \request()->user();
        if ($user->type!='TEACHER'){
            return response()->json(['message' => "Wrong credentials."], 401); // HTTP_UNAUTHORIZED
        }
        $coupon=Coupon::where(['price'=>$money,'status'=>1])->first();
        if(!$coupon){
            $coupon=Coupon::create([
                'name_ar'=>$money,
                'name_en'=>$money,
                'price'=>$money
            ]);
        }
        return response()->json(['qr' => 'G-Courses-'.($coupon->id*28).rand(111111111,999999999).'-'.rand(1111,9999).(\request()->user()->id*7)]);
    }
}
