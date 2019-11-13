<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentUser extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        $condition = true; // show email or not depending on the condition
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->when($condition, $this->email)
        ];
    }
}
