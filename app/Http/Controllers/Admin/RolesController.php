<?php

namespace App\Http\Controllers\Admin;

use Silber\Bouncer\Bouncer;
use Silber\Bouncer\Database\Ability;
use Silber\Bouncer\Database\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRolesRequest;
use App\Http\Requests\Admin\UpdateRolesRequest;
use ViewComponents\Eloquent\EloquentDataProvider;
use ViewComponents\Grids\Component\Column;
use ViewComponents\Grids\Grid;
use ViewComponents\ViewComponents\Customization\CssFrameworks\BootstrapStyling;

class RolesController extends Controller
{
    /**
     * Display a listing of Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( !Gate::allows( 'users_manage' ) ) {
            return abort( 401 );
        }


        $provider = new EloquentDataProvider( Role::class );

        $columns = [
            new Column( 'name' ),
            new Column( 'title' ),

            ( new Column( 'actions', '' ) )
                ->setValueCalculator( function ( $row ) {
                    $edit =  link_to_route( 'admin.roles.edit', '', [ $row->id ], [ 'class' => 'btn btn-sm btn-info fa fa-pencil' ] );
                    $delete = link_to_route( 'admin.roles.destroy', '', $row->id, [
                        'class'        => 'btn btn-sm btn-danger fa fa-trash',
                        'data-method'  => "delete",
                        'data-confirm' => "Are you sure?",

                    ] );
                    return $edit . " " . $delete;
                } ),
        ];

        $grid = new Grid( $provider, $columns );
        $grid->getColumn( 'actions' )->getDataCell()->setAttribute( 'class', 'fit-cell' );
        BootstrapStyling::applyTo( $grid );



        return view( 'admin.roles.index', compact( 'grid' ) );
    }

    /**
     * Show the form for creating new Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ( !Gate::allows( 'users_manage' ) ) {
            return abort( 401 );
        }
        $abilities = Ability::get()->pluck( 'name', 'name' );

        return view( 'admin.roles.create', compact( 'abilities' ) );
    }

    /**
     * Store a newly created Role in storage.
     *
     * @param StoreRolesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store( StoreRolesRequest $request )
    {

        if ( !Gate::allows( 'users_manage' ) ) {
            return abort( 401 );
        }
        $role = Role::create( $request->all() );
        $role->allow( $request->input( 'abilities' ) );

        return redirect()->route( 'admin.roles.index' );
    }


    /**
     * Show the form for editing Role.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {
        if ( !Gate::allows( 'users_manage' ) ) {
            return abort( 401 );
        }
        $abilities = Ability::get()->pluck( 'name', 'name' );

        $role = Role::findOrFail( $id );

        return view( 'admin.roles.edit', compact( 'role', 'abilities' ) );
    }

    /**
     * Update Role in storage.
     *
     * @param  UpdateRolesRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update( UpdateRolesRequest $request, $id )
    {
        if ( !Gate::allows( 'users_manage' ) ) {
            return abort( 401 );
        }
        $role = Role::findOrFail( $id );
        $role->update( $request->all() );
        foreach ( $role->getAbilities() as $ability ) {
            $role->disallow( $ability->name );
        }
        $role->allow( $request->input( 'abilities' ) );

        return redirect()->route( 'admin.roles.index' );
    }


    /**
     * Remove Role from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id )
    {
        if ( !Gate::allows( 'users_manage' ) ) {
            return abort( 401 );
        }
        $role = Role::findOrFail( $id );
        $role->delete();

        return redirect()->route( 'admin.roles.index' );
    }

    /**
     * Delete all selected Role at once.
     *
     * @param Request $request
     */
    public function massDestroy( Request $request )
    {
        if ( !Gate::allows( 'users_manage' ) ) {
            return abort( 401 );
        }
        if ( $request->input( 'ids' ) ) {
            $entries = Role::whereIn( 'id', $request->input( 'ids' ) )->get();

            foreach ( $entries as $entry ) {
                $entry->delete();
            }
        }
    }

}
