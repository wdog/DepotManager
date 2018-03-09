<?php

namespace App\Http\Controllers;

use App\Depot;
use App\Group;
use App\Http\Requests\StoreDepotRequest;
use App\Http\Requests\UpdateDepotRequest;
use App\Policies\DepotPolicy;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class DepotController
 *
 * @package App\Http\Controllers
 */
class DepotController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $depots = Depot::list()->paginate( 5 );
        return view( 'depots.index', compact( 'depots' ) );
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function create()
    {
        if ( !\Gate::allows( 'depots_manage' ) ) {
            return abort( 401 );
        }

        $groups = Group::pluck( 'name', 'id' );
        return view( 'depots.create', compact( 'groups' ) );

    }


    /**
     * @param StoreDepotRequest $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function store( StoreDepotRequest $request )
    {
        if ( !Gate::allows( 'depots_manage' ) ) {
            return abort( 401 );
        }

        Depot::create( $request->all() );
        return redirect()->route( 'depots.index' );
    }


    /**
     * @param Depot $depot
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit( Depot $depot )
    {
        $groups = Group::pluck( 'name', 'id' );
        return view( 'depots.edit', compact( 'depot', 'groups' ) );
    }


    /**
     * @param Depot $depot
     * @param UpdateDepotRequest $request
     * @return \Illuminate\Http\RedirectResponse|void
     * @internal param Group $group
     */
    public function update( Depot $depot, UpdateDepotRequest $request )
    {
        if ( !Gate::allows( 'depots_manage' ) ) {
            return abort( 401 );
        }
        $depot->update( $request->all() );
        return redirect()->route( 'depots.index' );
    }

    /**
     * @param Depot $depot
     */
    public function show( Depot $depot )
    {
        $this->authorize( 'view', $depot );
        // TODO
        dd( $depot );
    }


    /**
     * @param Depot $depot
     */
    public function delete( Depot $depot )
    {
// TODO
    }
}
