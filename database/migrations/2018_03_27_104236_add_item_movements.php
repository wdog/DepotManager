<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddItemMovements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'movements', function ( Blueprint $table ) {
            $table->integer( 'item_id' )->unsigned()->after( 'id' )->nullable();
            $table->foreign( 'item_id' )->references( 'id' )->on( 'items' )->onDelete( 'set Null' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'movements', function ( Blueprint $table ) {
            $table->dropForeign('movements_item_id_foreign');
            $table->dropColumn( 'item_id' );
        } );
    }
}
