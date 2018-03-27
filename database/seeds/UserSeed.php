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


        $group_1 = \App\Group::create( [
            'name' => 'Administrators',
            'slug' => 'admin',
        ] );


        $user_1 = User::create( [
            'name'     => 'Admin',
            'email'    => 'admin@ex.com',
            'password' => bcrypt( 'admin' ),
            'group_id' => $group_1->id,
        ] );


        $user_1->assign( 'administrator' );

        // USERS
        $group_2 = \App\Group::create( [
            'name' => 'Consalvi',
            'slug' => 'consalvi',
        ] );

        $user_2 = User::create( [
            'name'     => 'consalvi',
            'email'    => 'consalvi@fibraweb.it',
            'password' => bcrypt( 'consalvi' ),
            'group_id' => $group_2->id,
        ] );

        $user_2->assign( 'worker' );
        // USERS
        $group_3 = \App\Group::create( [
            'name' => 'Tenerini',
            'slug' => 'tenerini',
        ] );

        $user_3 = User::create( [
            'name'     => 'tenerini',
            'email'    => 'tenerini@fibraweb.it',
            'password' => bcrypt( 'tenerini' ),
            'group_id' => $group_3->id,
        ] );

        $user_3->assign( 'worker' );


        $depot_1 = \App\Depot::create( [
            'name'     => 'DEPOSITO 1',
            'group_id' => $group_2->id,
        ] );

        $depot_2 = \App\Depot::create( [
            'name'     => 'DEPOSITO 2',
            'group_id' => $group_3->id,
        ] );

        $project_1 = \App\Project::create( [
            'name' => 'Project 1',
        ] );
        $project_1->groups()->attach( $group_1 );
        $project_1->groups()->attach( $group_2 );

        $project_1 = \App\Project::create( [
            'name' => 'Project 2',
        ] );
        $project_1->groups()->attach( $group_1 );
        $project_1->groups()->attach( $group_2 );


        \App\Item::create( [
            'code' => 'PZ40',
            'name' => 'Pozzetti 40x40',
            'um'   => 'NR',
        ] );

        \App\Item::create( [
            'code' => 'PZ60',
            'name' => 'Pozzetti 60x60',
            'um'   => 'NR',
        ] );

        \App\Item::create( [
            'code' => 'F_24',
            'name' => 'Fibra 24',
            'um'   => 'MT',
        ] );

        \App\Item::create( [
            'code' => 'F_144',
            'name' => 'Fibra 144',
            'um'   => 'MT',
        ] );






    }

}
