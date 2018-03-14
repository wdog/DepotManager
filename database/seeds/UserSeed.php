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

        $group2 = \App\Group::create( [
            'name' => 'Workers',
            'slug' => 'workers',
        ] );

        $user2 = User::create( [
            'name'     => 'Coyote',
            'email'    => 'coyote@ex.com',
            'password' => bcrypt( 'coyote' ),
            'group_id' => $group2->id,
        ] );

        $user->assign( 'worker' );

    }
}
