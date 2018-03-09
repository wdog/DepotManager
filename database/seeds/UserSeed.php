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
        \App\Group::create( [
            'name' => 'Workers',
            'slug' => 'workers',
        ] );


        $group = \App\Group::create( [
            'name' => 'Administrators',
            'slug' => 'admin',
        ] );


        $user = User::create( [
            'name'     => 'Admin',
            'email'    => 'admin@ex.com',
            'password' => bcrypt( 'admin' ),
            'group_id' => $group->id,
        ] );


        $user->assign( 'administrator' );
    }
}
