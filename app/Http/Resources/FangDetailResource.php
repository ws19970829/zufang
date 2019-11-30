<?php

namespace App\Http\Resources;

use App\Models\FangAttr;
use Illuminate\Http\Resources\Json\JsonResource;

class FangDetailResource extends JsonResource
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
           'pic'=>$this->fang_pic,
           'name'=>$this->fang_name,
           'time'=>date('Y-m-d',strtotime($this->created_at)),
           'area'=>$this->fang_build_area,
           'room'=>$this->fang_shi.'室'.$this->fang_ting.'厅'.$this->fang_wei.'卫',
           'rent'=>$this->fang_rent,
           'dir'=>FangAttr::where('id',$this->fang_direction)->value('name'),
           'floor'=>$this->fang_floor,
           'year'=>$this->fang_year,
           'config'=>FangAttr::whereIn('id',explode(',',$this->fang_config))->pluck('name'),
           'desn'=>$this->fang_desn,
           'latitude'=>$this->latitude,
           'longitude'=>$this->longitude,
           'foid'=>$this->fangOwner->id,
            'foname'=>$this->fangOwner->name,
           'phone'=>$this->fangOwner->phone,
       ];
    }
}
