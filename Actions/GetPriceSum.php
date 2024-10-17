<?php

namespace Modules\Pricing\Actions;

use Modules\Core\Abstracts\ActionItem;
use Modules\Core\Entities\Action;
use Modules\Pricing\Entities\Price;

class GetPriceSum extends ActionItem
{

    /**
     * @inheritDoc
     */
    public function logic()
    {
        $total = 0;
        foreach( $this->getParam( 'class_data' ) as $item )
        {
            $price = Action::build( 'pricing', 'get-price' , [ 'id' =>  $item[ 'price_id' ] ] )->execute();
            $total += $price->price * $item[ 'quantity' ];
        }   
        return $total;
    }

    public function getValidation(): array
    {
        return 
        [ 
            'class_type'    =>  'required|string',
            'class_data'     =>  'required|array',
        ];
    }
}
