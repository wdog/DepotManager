<?php

namespace App\Http\Controllers\Admin;


use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGroupsRequest;
use App\Http\Requests\Admin\UpdateGroupsRequest;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Session\Store;

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

        $groups = Group::with( 'users' )->get();

        return view( 'admin.groups.index', compact( 'groups' ) );
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
