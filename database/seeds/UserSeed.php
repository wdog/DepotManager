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
            'name'     => 'Carlo Chech',
            'email'    => 'carlo.chech@fibraweb.it',
            'password' => bcrypt( 'secret' ),
            'group_id' => $adminGroup->id,
        ] )->assign( 'administrator' );

        User::create( [
            'name'     => 'Domenico Basile',
            'email'    => 'domenico.basile@fibraweb.it',
            'password' => bcrypt( 'domenico' ),
            'group_id' => $adminGroup->id,
        ] )->assign( 'administrator' );


        User::create( [
            'name'     => 'Elisa Sportoletti',
            'email'    => 'elisa.sportoletti@fibraweb.it',
            'password' => bcrypt( 'elisa' ),
            'group_id' => $adminGroup->id,
        ] )->assign( 'administrator' );

        // USER GROUP 1
        $group_1 = \App\Group::create( [
            'name' => 'Consalvi',
            'slug' => 'consalvi',
        ] );

        User::create( [
            'name'     => 'consalvi',
            'email'    => 'consalvi@fibraweb.it',
            'password' => bcrypt( 'consalvi' ),
            'group_id' => $group_1->id,
        ] )->assign( 'worker' );
        // USER GROUP 2
        $group_2 = \App\Group::create( [
            'name' => 'Tenerini',
            'slug' => 'tenerini',
        ] );

        User::create( [
            'name'     => 'tenerini',
            'email'    => 'tenerini@fibraweb.it',
            'password' => bcrypt( 'tenerini' ),
            'group_id' => $group_2->id,
        ] )->assign( 'worker' );


        \App\Depot::create( [ 'name' => 'DEPOSITO ' . $group_1->name, 'group_id' => $group_1->id ] );
        \App\Depot::create( [ 'name' => 'DEPOSITO ' . $group_2->name, 'group_id' => $group_2->id ] );
        \App\Depot::create( [ 'name' => 'DEPOSITO ' . $adminGroup->name, 'group_id' => $adminGroup->id, ] );

        $project_1 = \App\Project::create( [
            'name' => 'Project 1',
        ] );
        $project_1->groups()->attach( $adminGroup );
        $project_1->groups()->attach( $group_1 );

        $project_1 = \App\Project::create( [
            'name' => 'Project 2',
        ] );
        $project_1->groups()->attach( $adminGroup );
        $project_1->groups()->attach( $group_1 );


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
