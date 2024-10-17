<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'pricing_prices' , function ( Blueprint $table )
        {
            $table->id();
            $table->morphs( "item" );
            $table->unsignedBigInteger( "currency_id" );
            $table->foreign( "currency_id" )->references( "id" )->on( "pricing_currencies" );
            $table->double( "price" );
            $table->softDeletes();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'pricing_prices' );
    }
}
