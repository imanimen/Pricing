<?php

namespace Modules\Pricing\Actions;

use Modules\Core\Abstracts\ActionItem;
use Modules\Pricing\Entities\Price;

class GetLatestPriceByClassAction extends ActionItem
{

    /**
     * @inheritDoc
     */
    public function logic()
    {
        return Price::whereItemType( $this->getParam( 'class' , 1 ) )->latest()->first();
    }
}
