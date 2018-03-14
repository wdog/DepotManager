<?php

namespace App\Policies;

use App\Depot;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepotPolicy
{
    use HandlesAuthorization;


    public function before( $user )
    {
        if ( $user->isAn( 'administrator' ) ) {
            return true;
        }
    }


    /**
     * Determine whether the user can view the depot.
     *
     * @param  \App\User $user
     * @param  Depot $depot
     * @return mixed
     */
    public function view( User $user, Depot $depot )
    {
        return ( $depot->group_id == $user->group_id );
    }

    /**
     * Determine whether the user can create depots.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create( User $user )
    {
        return false;
    }

    /**
     * Determine whether the user can update the depot.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function update( User $user )
    {
        return false;
    }

    /**
     * Determine whether the user can delete the depot.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function delete( User $user )
    {
        return false;
    }


}
