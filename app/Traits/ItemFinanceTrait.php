<?php

namespace App\Traits;

use App\Models\Item;

/**
 * Created by PhpStorm.
 * User: MoWagdy
 * Date: 2019-09-20
 * Time: 11:49 AM
 */
trait ItemFinanceTrait
{
    public function calculateDoctorMoney(Item $item, $doctorId)
    {
        $totalItemMoney = $item->usersHaveBought->sum('amount');
        $totalPoints = $item->itemAuthors->sum('points');
        $doctorPoints = $item->itemAuthors->where('author_id', $doctorId)->first()->points;

        //

        return ($doctorPoints / $totalPoints) * $totalItemMoney;
    }

    public function calculateCreatorStudentMoney(Item $item, $doctorId)
    {
        $totalItemMoney = $item->usersHaveBought->sum('amount');

        //

        return $totalItemMoney;
    }


}
