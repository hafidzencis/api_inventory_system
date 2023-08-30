<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Vendor extends JsonResource
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
            'id'=> $this->id,
            'vendor_name' => $this->vendor_name,
            'contact' => $this->contact,
            'email' => $this->email

        ];
    }
}
