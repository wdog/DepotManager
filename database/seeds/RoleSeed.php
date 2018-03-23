<?php

use Illuminate\Database\Seeder;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bouncer::allow('administrator')->to('users_manage');
        Bouncer::allow('administrator')->to('depots_manage');
        Bouncer::allow('administrator')->to('items_manage');
        Bouncer::allow('administrator')->to('projects_manage');
    }
}
