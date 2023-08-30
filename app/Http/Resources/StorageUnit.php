<?php

namespace App\Http\Resources;

use App\Http\Resources\Vendor as ResourcesVendor;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

class StorageUnit extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'vendor_id' => ResourcesVendor::collection($this->vendor) ,
            'warehouse_name' => $this->warehouse_name,
            'location' => $this->location
        ];
    }
}
