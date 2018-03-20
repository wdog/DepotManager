<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'movements', function ( Blueprint $table ) {
            $table->increments( 'id' );


            $table->integer( 'user_id' )->unsigned()->nullable();
            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' )->onDelete( 'cascade' );


            $table->integer( 'group_id' )->unsigned()->nullable();
            $table->foreign( 'group_id' )->references( 'id' )->on( 'groups' )->onDelete( 'cascade' );

            $table->integer( 'depot_item_id' )->unsigned()->nullable();
            $table->foreign( 'depot_item_id' )->references( 'id' )->on( 'depot_item' )->onDelete( 'cascade' );
            $table->integer( 'qta' )->nullable();
            $table->string( 'reason' )->nullable();
            $table->text( 'info' )->nullable();

            $table->integer( 'movement_id' )->unsigned()->nullable();
            $table->foreign( 'movement_id' )->references( 'id' )->on( 'movements' )->onDelete( 'cascade' );
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
        Schema::dropIfExists( 'movements' );
    }
}
