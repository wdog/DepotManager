<?php

namespace App\Http\Controllers\Admin;


use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGroupsRequest;
use App\Http\Requests\Admin\UpdateGroupsRequest;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use ViewComponents\Eloquent\EloquentDataProvider;
use ViewComponents\Grids\Component\Column;
use ViewComponents\Grids\Grid;
use ViewComponents\ViewComponents\Customization\CssFrameworks\BootstrapStyling;

/**
 * Class GroupsController
 *
 * @package App\Http\Controllers\Admin
 */
class GroupsController extends Controller
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
        $provider = new EloquentDataProvider( Group::with('users'));
        $columns = [
            new Column( 'name' ,trans('global.name') ),

            ( new Column( 'users', trans('global.users.title') ) )->setValueFormatter( function ( $row ) {
                $u = '';
                foreach( $row as $user){
                    $u .= "<li class='list-group-item list-group-item-text list-group-item-info'>" . $user->name . "</li>";
                }
                return "<ul class='list-group '>" . $u . "</ul>";
            } ),

            ( new Column( 'actions', '' ) )
                ->setValueCalculator( function ( $row ) {
                    $edit = link_to_route( 'admin.groups.edit', '', [ $row->id ], [ 'class' => 'btn btn-sm btn-info fa fa-pencil' ] );
                    $delete = link_to_route( 'admin.groups.destroy', '', $row->id, [
                        'class'        => 'btn btn-sm btn-danger fa fa-trash',
                        'data-method'  => "delete",
                        'data-confirm' => "Are you sure?",

                    ] );
                    return $edit . " " . $delete;
                } ),
        ];

        $grid = new Grid( $provider, $columns );
        BootstrapStyling::applyTo( $grid );
        $grid->getColumn( 'actions' )->getDataCell()->setAttribute( 'class', 'fit-cell' );
        return view( 'admin.groups.index', compact( 'grid' ) );
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
        return view( 'admin.groups.create' );
    }


    /**
     * @param StoreGroupsRequest $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function store( StoreGroupsRequest $request )
    {
        if ( !Gate::allows( 'users_manage' ) ) {
            return abort( 401 );
        }

        Group::create( $request->all() );


        return redirect()->route( 'admin.groups.index' );
    }


    /**
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function edit( Group $group )
    {
        if ( !Gate::allows( 'users_manage' ) ) {
            return abort( 401 );
        }
        return view( 'admin.groups.edit', compact( 'group' ) );
    }

    /**
     * @param Group $group
     * @param UpdateGroupsRequest $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function update( Group $group, UpdateGroupsRequest $request )
    {
        if ( !Gate::allows( 'users_manage' ) ) {
            return abort( 401 );
        }
        $group->update( $request->all() );
        return redirect()->route( 'admin.groups.index' );
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
        $group = Group::findOrFail( $id );
        $group->delete();

        return redirect()->route( 'admin.groups.index' );
    }
}
