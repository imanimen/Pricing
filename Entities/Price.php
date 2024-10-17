<?php

namespace Modules\Pricing\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Model
{
    use SoftDeletes;

    protected $table    = "pricing_prices";
    protected $fillable = [ "item_type" , "item_id" , "currency_id" , "price" ];
    protected $appends  = [ "currency" ];

    public function currency()
    {
        return $this->hasOne( Currency::class , "id" , "currency_id" );
    }

    public function getCurrencyAttribute()
    {
        return $this->currency()->first()->code ?? "USD";
    }

}
