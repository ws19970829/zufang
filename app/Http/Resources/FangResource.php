<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FangResource extends JsonResource
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
            'id'=>$this->id,
            'pic'=>$this->fang_pic[0],
            'name'=>$this->fang_name,
            'area'=>$this->fang_build_area,
            'room'=>$this->fang_shi.'室'.$this->fang_ting.'卫',
            'rent'=>$this->fang_rent
        ];
    }
}
