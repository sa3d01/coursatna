<?php

namespace App\Http\Resources\Coupon;

use App\Http\Resources\AuthUsers\StudentUserDTO;
use App\Http\Resources\General\LevelDTO;
use App\Http\Resources\General\SubjectDTO;
use Illuminate\Http\Resources\Json\JsonResource;
use phpDocumentor\Reflection\Types\Object_;
use tests\Mockery\Adapter\Phpunit\EmptyTestCase;

class CouponResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'price' => (int)$this->price,
        ];
    }
}
