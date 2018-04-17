<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $adminGroup = \App\Group::create( [
            'name' => 'Administrators',
            'slug' => 'admin',
        ] );


        User::create( [
            'name'     => 'admin',
            'email'    => 'admin@test.me',
            'password' => bcrypt( 'secret' ),
            'group_id' => $adminGroup->id,
        ] )->assign( 'administrator' );



    }

}
