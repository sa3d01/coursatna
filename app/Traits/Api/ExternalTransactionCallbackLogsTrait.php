<?php
/**
 * Created by MoWagdy
 * Date: 2019-10-16
 * Time: 5:36 PM
 */

namespace App\Traits\Api;

use App\Models\ExternalTransactionLog;

trait ExternalTransactionCallbackLogsTrait
{
    public function saveLog($data)
    {
        return ExternalTransactionLog::create($data);
    }
}
