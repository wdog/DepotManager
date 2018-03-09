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
        $group = \App\Group::create( [
            'group_name' => 'Administrators',
            'slug'       => 'admin',
        ] );



        $user = User::create( [
            'name'     => 'Admin',
            'email'    => 'admin@admin.com',
            'password' => bcrypt( 'password' ),
            'group_id' => $group->id
        ] );


        $user->assign( 'administrator' );
    }
}
