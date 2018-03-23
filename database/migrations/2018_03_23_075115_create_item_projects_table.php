<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'item_projects', function ( Blueprint $table ) {
            $table->increments( 'id' );

            $table->integer( 'item_id' )->unsigned()->nullable();
            $table->foreign( 'item_id' )->references( 'id' )->on( 'items' )->onDelete( 'cascade' );

            $table->integer( 'project_id' )->unsigned()->nullable();
            $table->foreign( 'project_id' )->references( 'id' )->on( 'projects' )->onDelete( 'cascade' );

            $table->integer( 'qta_req' )->default( 0 );

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
        Schema::dropIfExists( 'item_projects' );
    }
}
