<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProjectToMovements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'movements', function ( Blueprint $table ) {
            $table->integer( 'project_id' )->unsigned()->after( 'id' )->nullable();
            $table->foreign( 'project_id' )->references( 'id' )->on( 'projects' )->onDelete( 'SET NULL' );

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
            $table->dropColumn( 'project_id' );
        } );
    }
}
