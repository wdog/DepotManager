<?php

namespace App\Http\Controllers;

use App\Depot;
use App\Group;
use App\Http\Requests\StoreDepotRequest;
use App\Http\Requests\StoreItemDepotRequest;
use App\Http\Requests\StoreMovementRequest;
use App\Http\Requests\UpdateDepotRequest;

use App\Item;
use App\Movement;
use App\Utils\ItemDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use ViewComponents\Eloquent\EloquentDataProvider;
use ViewComponents\Grids\Component\Column;
use ViewComponents\Grids\Component\DetailsRow;
use ViewComponents\Grids\Grid;
use ViewComponents\ViewComponents\Component\Control\PageSizeSelectControl;
use ViewComponents\ViewComponents\Component\Control\PaginationControl;
use ViewComponents\ViewComponents\Customization\CssFrameworks\BootstrapStyling;
use ViewComponents\ViewComponents\Data\ArrayDataProvider;
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
                new Column( 'name' ),
                new Column( 'group.name', 'Group' ),
                ( new Column( 'actions', '' ) )
                    ->setValueCalculator( function ( $row ) {

                        $edit = '';
                        $delete = '';
                        // only admin can update depot
                        if ( Auth::user()->can( 'update', Depot::class ) ) {
                            $edit = link_to_route( 'depots.edit', '', $row->id, [ 'class' => 'btn btn-info fa fa-pencil' ] );
                        }
                        // only admin can delete depot
                        if ( Auth::user()->can( 'delete', Depot::class ) ) {
                            $delete = link_to_route( 'depots.destroy', '', $row->id, [
                                'class'        => 'btn btn-danger fa fa-trash',
                                'data-method'  => "delete",
                                'data-confirm' => "Are you sure?",

                            ] );
                        }
                        // view button
                        $view = link_to_route( 'depots.show', '', $row->id, [ 'class' => 'btn btn-success fa fa-eye' ] );

                        $buttons = '<div class="btn-group btn-group-xs" role="group" aria-label="actions">';
                        $buttons .= $view . " " . $edit . " " . $delete;
                        $buttons .= '</div>';

                        return $buttons;
                    } ),

                new PageSizeSelectControl( $input->option( 'ps', 4 ), [ 2, 4, 10, 100 ] ),
                new PaginationControl( $input->option( 'page', 1 ), 5 ),
            ]
        );
        BootstrapStyling::applyTo( $grid );
        $grid->getColumn( 'actions' )->getDataCell()->setAttribute( 'class', 'fit-cell' );
        $grid->getTileRow()->detach()->attachTo( $grid->getTableHeading() );
        $grid = $grid->render();

        return view( 'depots.index', compact( 'grid' ) );
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
     * @return \Illuminate\Http\RedirectResponse
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
     * @return \Illuminate\Http\RedirectResponse
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
        $provider = new ArrayDataProvider( $depot->items );

        $columns = [
            new Column( 'code' ),
            new Column( 'pivot.serial', 'Serial' ),
            ( new Column( 'pivot.qta_depot', 'Qta' ) )
                ->setValueCalculator( function ( $row ) {
                    return $row->pivot->qta_depot . " <small>" . $row->um . "</small>";
                } ),

            ( new Column( 'actions', '' ) )
                ->setValueCalculator( function ( $row ) use ( $depot ) {
                    return link_to_route( 'depots.unload_item', '', [ $depot, $row->pivot->id ], [ 'class' => 'btn btn-xs btn-info fa fa-pencil' ] );

                } ),

            new DetailsRow( new ItemDetail() ),
        ];

        $grid = new Grid( $provider, $columns );
        BootstrapStyling::applyTo( $grid );

        $grid->getColumn( 'pivot.qta_depot' )->getDataCell()->setAttribute( 'class', 'text-right' );
        $grid->getColumn( 'actions' )->getDataCell()->setAttribute( 'class', 'fit-cell' );
        return view( 'depots.view', compact( 'depot', 'grid' ) );
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


    /**
     * @param Depot $depot
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addItem( Depot $depot )
    {
        if ( !Gate::allows( 'depots_manage' ) ) {
            return abort( 401 );
        }
        $items = \App\Item::enabled()->get()->pluck( 'full_name', 'id' );
        return view( 'depots.items.add', compact( 'depot', 'items' ) );
    }


    /**
     * @param StoreItemDepotRequest $request
     * @param Depot $depot
     * @return string
     */
    public function storeItem( StoreItemDepotRequest $request, Depot $depot )
    {
        if ( !Gate::allows( 'depots_manage' ) ) {
            return abort( 401 );
        }

        $depot->items()->attach( $request->item_id, [
            'qta_ini'   => $request->qta_ini,
            'qta_depot' => $request->qta_ini,
            'serial'    => $request->serial,
        ] );

        return redirect()->route( 'depots.show', $depot );
    }

    /**
     * @param Depot $depot
     * @param $pivot_id
     * @internal param Item $item
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function unloadItem( Depot $depot, $pivot_id )
    {
        $item = $depot->items()->where( 'depot_item.id', $pivot_id )->first();

        return view( 'depots.items.unload', compact( 'depot', 'item' ) );

    }


    public function createMovementItem( StoreMovementRequest $request, Depot $depot, $pivot_id )
    {
        $this->authorize( 'view', $depot );

        $item = $depot->items()->where( 'depot_item.id', $pivot_id )->first();

        if ( $item->pivot->qta_depot - $request->qta >= 0 ) {
            $item->pivot->decrement( 'qta_depot', $request->qta );
            // create movement
            $mov = new Movement();
            $mov->user_id = Auth::id();
            $mov->group_id = Auth::user()->group_id;
            $mov->qta = $request->qta;
            $mov->reason = $request->reason;
            $mov->depot_item_id = $pivot_id;
            $mov->info = "Unload";
            $mov->save();
        } else {
            $request->session()->flash( 'error', 'too many items to unload' );

        }

        return redirect()->route( 'depots.show', $depot );

    }
}
