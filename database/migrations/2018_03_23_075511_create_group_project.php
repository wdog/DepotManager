<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'group_project', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->integer( 'group_id' )->unsigned()->nullable();
            $table->foreign( 'group_id' )->references( 'id' )->on( 'groups' )->onDelete( 'cascade' );

            $table->integer( 'project_id' )->unsigned()->nullable();
            $table->foreign( 'project_id' )->references( 'id' )->on( 'projects' )->onDelete( 'cascade' );
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
        Schema::dropIfExists( 'group_project' );
    }
}
