<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */

    public function toArray($request)
    {
        dd($this->co_usuario);
        return [
            'value'     => $this->co_usuario,
            'text'      => $this->no_usuario,
        ];
    }
}
