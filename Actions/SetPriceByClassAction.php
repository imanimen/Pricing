<?php

namespace Modules\Pricing\Actions;

use Modules\Core\Abstracts\ActionItem;
use Modules\Pricing\Entities\Price;

class SetPriceByClassAction extends ActionItem
{

    public function getValidation(): array
    {
        return [
            'id'       => 'nullable' ,
            'class'    => 'required|string' ,
            'price'    => 'required|integer' ,
            'currency' => 'required|exists:pricing_currencies,id' ,
        ];
    }

    /**
     * @inheritDoc
     */
    public function logic()
    {
        $type     = $this->getParam( 'class' );
        $id       = $this->getParam( 'id' , 0 );
        $currency = $this->getParam( 'currency' );
        $price    = $this->getParam( 'price' );
        return Price::create( [
                                  'item_type'   => $type ,
                                  'item_id'     => $id ,
                                  'currency_id' => $currency ,
                                  'price'       => $price ,
                              ] );
    }
}
