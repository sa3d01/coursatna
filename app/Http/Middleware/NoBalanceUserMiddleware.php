<?php

namespace App\Http\Middleware;

use App\Models\MoneyAccount;
use Closure;
use Illuminate\Routing\Route;

class NoBalanceUserMiddleware
{
    private $route;

    public function __construct(Route $route)
    {
        $this->route = $route;
    }

    public function handle($request, Closure $next)
    {

        if (auth()->guard('api')->check() && in_array('POST', $this->route->methods)) {
            $moneyAccount = MoneyAccount::where([
                'ref_model' => 'User',
                'ref_id' => auth()->guard('api')->id(),
            ])->first();
            //if (!$moneyAccount || count($moneyAccount->externalTransactions) < 1) {
            if (!$moneyAccount || $moneyAccount->balance == 0) {
                return response()->json([
                    'message' => 'برجاء شحن حسابك حتى يمكنك إستخدام هذه الخدمة، مع العلم ان هذه الخدمة مجانية ولن يتم خصم مقابل مادي',
                ], 400);
            }
        }

        return $next($request);
    }
}
