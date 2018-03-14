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
use ViewComponents\Eloquent\EloquentDataProvider;
use ViewComponents\Grids\Component\Column;
use ViewComponents\Grids\Grid;
use ViewComponents\ViewComponents\Component\Control\PageSizeSelectControl;
use ViewComponents\ViewComponents\Component\Control\PaginationControl;
use ViewComponents\ViewComponents\Customization\CssFrameworks\BootstrapStyling;
use ViewComponents\ViewComponents\Input\InputSource;

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

        $provider = new EloquentDataProvider( Depot::list() );
        $input = new InputSource( $_GET );
        $grid = new Grid(
            $provider, [
                ( new Column( 'name' ) ),
                ( new Column( 'actions' ) )
                    ->setValueCalculator( function ( $row ) {

                        $edit = '';
                        $delete = '';

                        if (Auth::user()->can('update'))
                            $edit = link_to_route( 'depots.edit', '', $row->id, [ 'class' => 'btn btn-xs btn-info fa fa-pencil' ] );
                        if (Auth::user()->can('delete'))
                        $delete = link_to_route( 'depots.destroy', '', $row->id, [
                            'class'        => 'btn btn-xs btn-danger fa fa-trash',
                            'data-method'  => "delete",
                            'data-confirm' => "Are you sure?",

                        ] );
                        $view = link_to_route( 'depots.show', '', $row->id, [ 'class' => 'btn btn-xs btn-success fa fa-eye' ] );
                        return $view . " " . $edit . " " . $delete;
                    } ),

                new PageSizeSelectControl( $input->option( 'ps', 4 ), [ 2, 4, 10, 100 ] ),
                new PaginationControl( $input->option( 'page', 1 ), 5 ),
            ]
        );


        BootstrapStyling::applyTo( $grid );

        $grid->getColumn( 'actions' )->getDataCell()->setAttribute( 'style', 'width:180px' );

        $grid->getTileRow()->detach()->attachTo( $grid->getTableHeading() );
        $grid = $grid->render();

        return view( 'depots.index', compact( 'grid' ) );
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
        if ( !Gate::allows( 'depots_manage' ) ) {
            return abort( 401 );
        }
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show( Depot $depot )
    {
        $this->authorize( 'view', $depot );
        return view( 'depots.view', compact( 'depot' ) );
    }


    /**
     * @param Depot $depot
     */
    public function destroy( Depot $depot )
    {
        if ( !Gate::allows( 'depots_manage' ) ) {
            return abort( 401 );
        }
        // TODO
        // controllare che non ci sia nessun oggetto dentro poi si puo disabilitare non cancellare
    }
}
