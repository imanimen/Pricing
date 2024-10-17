<?php


namespace Modules\Pricing\Http\Traits;


use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\HomeAxel\Entities\UserAddress;
use Throwable;

trait Price
{
    public function setPrice( $price , int $currency_id )
    {
        \Modules\Pricing\Entities\Price::where( "item_type" , get_class( $this ) )->where( "item_id" , $this->id )->where( "currency_id" , $currency_id )->delete();
        \Modules\Pricing\Entities\Price::create( [
                                                     "item_type"   => get_class( $this ) ,
                                                     "item_id"     => $this->id ,
                                                     "price"       => $price ,
                                                     "currency_id" => $currency_id ,
                                                 ] );
    }

    /**
     * @return mixed
     */
    public function getPrices()
    {
        $prices = $this->prices->toQuery();
        if ( !is_null( auth()->user() ) )
        {
            try
            {
                $user      = User::find( auth()->user()->getAuthIdentifier() );
                $addresses = UserAddress::whereUserId( $user->id )->latest()->first();
                return $prices->whereCurrencyId( $addresses->country_id )->get();
            }
            catch ( Exception | Throwable $e )
            {
                return $prices->get();
            }
        }
        return $prices->get();
    }

    /**
     * @return MorphMany
     */
    public function prices()
    {
        return $this->morphMany( \Modules\Pricing\Entities\Price::class , 'item' );

    }

    public function getPrice( int $currency_id = 1 )
    {
        return \Modules\Pricing\Entities\Price::where( "item_type" , get_class( $this ) )->where( "item_id" , $this->id )->where( "currency_id" , $currency_id )->first();
    }

    public function latestPrice()
    {
        return $this->morphOne(\Modules\Pricing\Entities\Price::class , 'item')
            ->latestOfMany();
    }
}
