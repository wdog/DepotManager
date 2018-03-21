<?php

namespace App\Http\Controllers;

use App\Depot;
use App\DepotItem;
use App\Group;
use App\Http\Requests\StoreDepotRequest;
use App\Http\Requests\StoreItemDepotRequest;
use App\Http\Requests\StoreMovementRequest;
use App\Http\Requests\UpdateDepotRequest;

use App\Item;
use App\Movement;
use App\Utils\DepotItemDetail;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Auth;
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

                new Column( 'name', trans( 'global.name' ) ),
                new Column( 'group.name', trans( 'global.groups.title' ) ),
                ( new Column( 'actions', '' ) )
                    ->setValueCalculator( function ( $row ) {

                        $edit = '';
                        $delete = '';
                        // only admin can update depot
                        if ( Auth::user()->can( 'update', Depot::class ) ) {
                            $edit = link_to_route( 'depots.edit', '', $row->id, [ 'class' => 'btn btn-sm btn-info fa fa-pencil' ] );
                        }
                        // only admin can delete depot
                        if ( Auth::user()->can( 'delete', Depot::class ) ) {
                            $delete = link_to_route( 'depots.destroy', '', $row->id, [
                                'class'        => 'btn btn-danger btn-sm fa fa-trash',
                                'data-method'  => "delete",
                                'data-confirm' => "Are you sure?",

                            ] );
                        }
                        // view button
                        $view = link_to_route( 'depots.show', '', $row->id, [ 'class' => 'btn btn-sm btn-success fa fa-eye' ] );
                        $buttons = $view . " " . $edit . " " . $delete;
                        return $buttons;
                    } ),

                new PageSizeSelectControl( $input->option( 'ps', 4 ), [ 2, 4, 10, 100 ] ),
                new PaginationControl( $input->option( 'page', 1 ), 5 ),
            ]
        );

        BootstrapStyling::applyTo( $grid );
        $grid->getColumn( 'actions' )->getDataCell()->setAttribute( 'class', 'fit-cell' );
        $grid->getTileRow()->detach()->attachTo( $grid->getTableHeading() );

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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show( Depot $depot )
    {
        $this->authorize( 'view', $depot );
        $provider = new ArrayDataProvider( $depot->itemsActive );

        $columns = [
            new Column( 'code', trans( 'global.code' ) ),
            new Column( 'pivot.serial', trans( 'global.serial' ) ),
            ( new Column( 'pivot.qta_ini', 'Qta', trans( 'global.qta' ) ) )// CHANGE XXX
            ->setValueCalculator( function ( $row ) {
                return $row->pivot->qta_depot . " <small>" . $row->um . "</small>";
            } ),

            ( new Column( 'actions', '' ) )
                ->setValueCalculator( function ( $row ) use ( $depot ) {
                    return link_to_route( 'depots.unload_item', '', [ $depot, $row->pivot->id ], [ 'class' => 'btn btn-sm btn-info fa fa-pencil' ] );

                } ),

            new DetailsRow( new DepotItemDetail() ),
        ];

        $grid = new Grid( $provider, $columns );


        $grid->getColumn( 'pivot.qta_ini' )->getDataCell()->setAttribute( 'class', 'text-right' );
        $grid->getColumn( 'actions' )->getDataCell()->setAttribute( 'class', 'fit-cell' );
        // $grid->setRecordView( new CustomRow() );
        BootstrapStyling::applyTo( $grid );
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
        $items = Item::enabled()->get()->pluck( 'full_name', 'id' );
        return view( 'depots.items.add', compact( 'depot', 'items' ) );
    }


    /**
     * ADMIN LOADS AN ITEM
     *
     * @param StoreItemDepotRequest $request
     * @param Depot $depot
     * @return string
     */
    public function storeItem( StoreItemDepotRequest $request, Depot $depot )
    {
        if ( !Gate::allows( 'depots_manage' ) ) {
            return abort( 401 );
        }
        $depotItem = DepotItem::create( [
            'item_id'   => $request->item_id,
            'depot_id'  => $depot->id,
            'qta_ini'   => $request->qta_ini,
            'qta_depot' => $request->qta_ini,
            'serial'    => $request->serial,
        ] );
        $this->createMovement( $request->qta_ini, "L", $depotItem->id, "SYSTEM LOAD" );
        return redirect()->route( 'depots.show', $depot );
    }

    /**
     *  FORM - SOMEONE UNLOAD ITEMS FROM DEPOT
     *
     * @param Depot $depot
     * @param $pivot_id
     * @internal param Item $item
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function unloadItem( Depot $depot, $pivot_id )
    {
        $item = $depot->items()->where( 'depot_item.id', $pivot_id )->first();

        $depots = Depot::where( 'id', '!=', $depot->id )->get()->pluck( 'full_name', 'id' );
        return view( 'depots.items.unload', compact( 'depot', 'item', 'depots' ) );

    }

    /**
     *
     * SOMEONE UNLOAD ITEMS FROM DEPOT
     *
     * @param StoreMovementRequest $request
     * @param Depot $depot
     * @param $pivot_id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function createMovementItem( StoreMovementRequest $request, Depot $depot, $pivot_id )
    {
        $this->authorize( 'view', $depot );


        $item = $depot->items()->where( 'depot_item.id', $pivot_id )->first();

        if ( $item->pivot->qta_depot - $request->qta >= 0 ) {

            if ( $request->depot_id ) {
                $reason = "M";
                $info = "TRANS DEPOT";
            } else {
                $reason = $request->reason;
                $info = "UNLOAD ITEM";
            }


            // unload item from source depot
            $item->pivot->decrement( 'qta_depot', $request->qta );
            // create movement unload
            $movement = $this->createMovement( -1 * $request->qta, $reason, $pivot_id, $info );


            // create movement load id a destination depot is defined
            if ( $request->depot_id ) {
                // find old item
                $item = DepotItem::find( $pivot_id );
                // find new depot
                $destDepot = Depot::find( $request->depot_id );
                // create load into new depot
                $depotItem = DepotItem::create(
                    [
                        'item_id'   => $item->item_id,
                        'depot_id'  => $destDepot->id,
                        'qta_ini'   => $request->qta,
                        'qta_depot' => $request->qta,
                        'serial'    => $item->serial,
                    ]
                );
                // create movement in new depot
                $this->createMovement( $request->qta, $reason, $depotItem->id, $info, $movement->id );
            }

        } else {
            $request->session()->flash( 'error', 'too many items to unload' );
        }

        return redirect()->route( 'depots.show', $depot );

    }


    /**
     * @param $qta
     * @param $reason
     * @param $pivot_id
     * @param $info
     * @return Movement
     */
    public function createMovement( $qta, $reason, $pivot_id, $info, $movement_id = null )
    {
        $mov = new Movement();
        $mov->user_id = Auth::id();
        $mov->group_id = Auth::user()->group_id;
        $mov->qta = $qta;
        $mov->reason = $reason;
        $mov->depot_item_id = $pivot_id;
        $mov->info = $info;
        $mov->movement_id = $movement_id;
        $mov->save();

        return $mov;
    }
}
