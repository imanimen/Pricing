<?php

namespace Modules\Pricing\Actions;

use Modules\Core\Abstracts\ActionItem;
use Modules\Pricing\Entities\Price;

class GetPriceAction extends ActionItem
{

    public function getCacheKey(): string
    {
        return 'price_by_price_id_'.$this->getParam( 'id' , 1 );
    }

    public function getCacheTTL(): int
    {
        return 60;
    }

    /**
     * @inheritDoc
     */
    public function logic()
    {
        return Price::findOrFail( $this->getParam( 'id' , 1 ) );
    }
}
