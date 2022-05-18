<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
class AuthencationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        $output = [
            'id' => $this->id,
            'company' => $this->company,
            'position' => $this->position,
            'email' => $this->email,
            'phone' => $this->phone,
            'token' => $this->token,
        ];
        return $output;
    }
}
