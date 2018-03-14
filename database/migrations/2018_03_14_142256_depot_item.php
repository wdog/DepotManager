<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DepotItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'depot_item', function ( Blueprint $table ) {
            $table->increments( 'id' );

            $table->integer( 'depot_id' )->unsigned()->nullable();
            $table->foreign( 'depot_id' )->references( 'id' )->on( 'depots' )->onDelete( 'cascade' );

            $table->integer( 'item_id' )->unsigned()->nullable();
            $table->foreign( 'item_id' )->references( 'id' )->on( 'items' )->onDelete( 'cascade' );

            $table->integer( 'qta_ini' )->default( 0 );
            $table->integer( 'qta_depot' )->default( 0 );
            $table->string( 'serial' )->nullable();


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
        Schema::dropIfExists( 'depot_item' );
    }
}
