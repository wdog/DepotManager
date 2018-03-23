<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClosedProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'projects', function ( Blueprint $table ) {
            $table->boolean( 'closed' )->default( false )->after( 'name' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'projects', function ( Blueprint $table ) {
            $table->dropColumn( 'closed' );

        } );
    }
}
