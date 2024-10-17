<?php

namespace Modules\Pricing\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PriceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     *
     * @return array
     */
    public function toArray( $request )
    {
        return [
            'price'    => $this->price ,
            'currency' => [
                'name' => $this->currency()->first()->name ,
                'code' => $this->currency()->first()->code ,
            ] ,
        ];
    }
}
