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

        // USERS
        $group2 = \App\Group::create( [
            'name' => 'Consalvi',
            'slug' => 'consalvi',
        ] );

        $user2 = User::create( [
            'name'     => 'consalvi',
            'email'    => 'consalvi@fibraweb.it',
            'password' => bcrypt( 'consalvi' ),
            'group_id' => $group2->id,
        ] );

        $user2->assign( 'worker' );
        // USERS
        $group3 = \App\Group::create( [
            'name' => 'Tenerini',
            'slug' => 'tenerini',
        ] );

        $user3 = User::create( [
            'name'     => 'tenerini',
            'email'    => 'tenerini@fibraweb.it',
            'password' => bcrypt( 'tenerini' ),
            'group_id' => $group3->id,
        ] );

        $user3->assign( 'worker' );
    }
}
