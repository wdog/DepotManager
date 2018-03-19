<?php

namespace App\Http\Controllers\Admin;

use App\Group;
use App\User;
use Silber\Bouncer\Database\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
use Bouncer;
use ViewComponents\Eloquent\EloquentDataProvider;
use ViewComponents\Grids\Component\Column;
use ViewComponents\Grids\Grid;
use ViewComponents\ViewComponents\Customization\CssFrameworks\BootstrapStyling;

class UsersController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( !Gate::allows( 'users_manage' ) ) {
            return abort( 401 );
        }

        $provider = new EloquentDataProvider( User::class );

        $columns = [
            new Column( 'name' ),
            new Column( 'email' ),
            new Column( 'group.name' ),

            ( new Column( 'actions', '' ) )
                ->setValueCalculator( function ( $row ) {
                    $edit = link_to_route( 'admin.users.edit', '', [ $row->id ], [ 'class' => 'btn btn-xs btn-info fa fa-pencil' ] );
                    $delete = link_to_route( 'admin.users.destroy', '', $row->id, [
                        'class'        => 'btn btn-xs btn-danger fa fa-trash',
                        'data-method'  => "delete",
                        'data-confirm' => "Are you sure?",

                    ] );
                    return $edit . " " . $delete;
                } ),
        ];

        $grid = new Grid( $provider, $columns );
        BootstrapStyling::applyTo( $grid );
        $grid->getColumn( 'actions' )->getDataCell()->setAttribute( 'class', 'fit-cell' );
        return view( 'admin.users.index', compact( 'grid' ) );
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ( !Gate::allows( 'users_manage' ) ) {
            return abort( 401 );
        }
        $roles = Role::get()->pluck( 'name', 'name' );
        $groups = Group::get()->pluck( 'name', 'id' );
        return view( 'admin.users.create', compact( 'roles', 'groups' ) );
    }

    /**
     * Store a newly created User in storage.
     *
     * @param StoreUsersRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store( StoreUsersRequest $request )
    {
        if ( !Gate::allows( 'users_manage' ) ) {
            return abort( 401 );
        }
        $user = User::create( $request->all() );

        foreach ( $request->input( 'roles' ) as $role ) {
            $user->assign( $role );
        }

        return redirect()->route( 'admin.users.index' );
    }


    /**
     * Show the form for editing User.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {
        if ( !Gate::allows( 'users_manage' ) ) {
            return abort( 401 );
        }
        $roles = Role::get()->pluck( 'name', 'name' );
        $groups = Group::get()->pluck( 'name', 'id' );


        $user = User::findOrFail( $id );

        return view( 'admin.users.edit', compact( 'user', 'roles', 'groups' ) );
    }

    /**
     * Update User in storage.
     *
     * @param UpdateUsersRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update( UpdateUsersRequest $request, $id )
    {
        if ( !Gate::allows( 'users_manage' ) ) {
            return abort( 401 );
        }
        $user = User::findOrFail( $id );
        $user->update( $request->all() );
        foreach ( $user->roles as $role ) {
            $user->retract( $role );
        }
        foreach ( $request->input( 'roles' ) as $role ) {
            $user->assign( $role );
        }

        return redirect()->route( 'admin.users.index' );
    }

    /**
     * Remove User from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id )
    {
        if ( !Gate::allows( 'users_manage' ) ) {
            return abort( 401 );
        }
        $user = User::findOrFail( $id );
        $user->delete();

        return redirect()->route( 'admin.users.index' );
    }

    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    public function massDestroy( Request $request )
    {
        if ( !Gate::allows( 'users_manage' ) ) {
            return abort( 401 );
        }
        if ( $request->input( 'ids' ) ) {
            $entries = User::whereIn( 'id', $request->input( 'ids' ) )->get();

            foreach ( $entries as $entry ) {
                $entry->delete();
            }
        }
    }

}
