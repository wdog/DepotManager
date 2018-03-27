<?php


namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\ItemProject;
use App\Movement;
use App\Utils\Helpers;
use App\Utils\ItemDetail;
use Illuminate\Support\Facades\Gate;

use App\Item;
use Illuminate\Http\Request;
use Psy\Util\Json;
use stdClass;
use ViewComponents\Eloquent\EloquentDataProvider;
use ViewComponents\Grids\Component\Column;
use ViewComponents\Grids\Component\CsvExport;
use ViewComponents\Grids\Component\DetailsRow;
use ViewComponents\Grids\Grid;
use ViewComponents\ViewComponents\Component\Control\FilterControl;
use ViewComponents\ViewComponents\Component\Control\PageSizeSelectControl;
use ViewComponents\ViewComponents\Component\Control\PaginationControl;
use ViewComponents\ViewComponents\Customization\CssFrameworks\BootstrapStyling;
use ViewComponents\ViewComponents\Data\ArrayDataProvider;
use ViewComponents\ViewComponents\Data\Operation\FilterOperation;
use ViewComponents\ViewComponents\Input\InputOption;
use ViewComponents\ViewComponents\Input\InputSource;


/**
 * Class ItemController
 *
 * @package App\Http\Controllers
 */
class ItemController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( !Gate::allows( 'items_manage' ) ) {
            return abort( 401 );
        }


        $provider = new EloquentDataProvider( Item::orderBy( 'name' ) );
        $input = new InputSource( $_GET );
        $grid = new Grid(
            $provider,
            // all components are optional, you can specify only columns
            [
                new FilterControl( 'code', FilterOperation::OPERATOR_STR_CONTAINS, $input->option( 'code' ) ),
                //new SelectFilterControl( 'um', Helpers::ComboUnita(), $input->option( 'um' ) ),

                new Column( 'code', trans( 'global.code' ) ),
                new Column( 'name', trans( 'global.name' ) ),
                ( new Column( 'qta', trans( 'global.qta' ) ) )->setValueCalculator( function ( $row ) {
                    return $row->available();
                } ),


                ( new Column( 'req', trans( 'global.qta' ) . "_Needs" ) )->setValueCalculator( function ( $row ) {
                    $req_projects = $this->getQtaFromProjects( $row->id );
                    $unloaded = $this->getQtaFromMovements( $row->id );
                    $val = $req_projects + $unloaded - $row->available();
                    return ( $val <= 0 ) ? 'OK' : $val;
                } ),


                ( new Column( 'actions', '' ) )
                    ->setValueCalculator( function ( $row ) {
                        $edit = link_to_route( 'items.edit', '', $row->id, [ 'class' => 'btn btn-sm btn-info fa fa-pencil' ] );
                        $delete = link_to_route( 'items.destroy', '', $row->id, [
                            'class'        => 'btn btn-sm btn-danger fa fa-trash',
                            'data-method'  => "delete",
                            'data-confirm' => "Are you sure?",

                        ] );
                        return $edit . " " . $delete;
                    } ),

                new DetailsRow( new ItemDetail() ),
                new PageSizeSelectControl( $input->option( 'ps', 50 ), [ 50, 100, 500 ] ),
                new PaginationControl( $input->option( 'page', 1 ), 5 ),

                new CsvExport( $input->option( 'csv' ) ),
            ] );

        // grid style
        BootstrapStyling::applyTo( $grid );
        // custom style
        $grid->getColumn( 'actions' )->getDataCell()->setAttribute( 'class', 'fit-cell' );
        $grid->getColumn( 'qta' )->getDataCell()->setAttribute( 'class', 'fit-cell text-right' );
        $grid->getColumn( 'req' )->getDataCell()->setAttribute( 'class', 'fit-cell text-right' );
        // filter on top of table
        $grid->getTileRow()->detach()->attachTo( $grid->getTableHeading() );
        $grid = $grid->render();

        return view( 'items.index', compact( 'grid' ) );


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ( !Gate::allows( 'items_manage' ) ) {
            return abort( 401 );
        }

        return view( 'items.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreItemRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store( StoreItemRequest $request )
    {
        if ( !Gate::allows( 'items_manage' ) ) {
            return abort( 401 );
        }

        Item::create( $request->all() );
        return redirect()->route( 'items.index' );

    }

    /**
     * @param Item $item
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit( Item $item )
    {
        return view( 'items.edit', compact( 'item' ) );
    }


    /**
     * @param Item $item
     * @param UpdateItemRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @internal param Group $group
     */
    public function update( Item $item, UpdateItemRequest $request )
    {
        if ( !Gate::allows( 'items_manage' ) ) {
            return abort( 401 );
        }

        $item->setAttribute( 'disabled', ( $request->has( 'disabled' ) ) ? true : false );

        $item->update( $request->all() );
        return redirect()->route( 'items.index' );
    }


    /**
     * @param Item $item
     * @return string
     */
    public function show( Item $item )
    {

        if ( !Gate::allows( 'items_manage' ) ) {
            return abort( 401 );
        }

        $provider = new ArrayDataProvider( [ $item ] );

        $grid = new Grid(
            $provider,
            [
                ( new Column( 'um' ) )->setLabel( 'Unit' ),

                ( new Column( 'disabled' ) )
                    ->setLabel( 'Status' )
                    ->setValueCalculator( function ( $row ) {
                        return Helpers::renderBool( $row->disabled );
                    } ),
            ] );
        BootstrapStyling::applyTo( $grid );
        return $grid->render();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Item $item
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy( Item $item )
    {
        if ( !Gate::allows( 'items_manage' ) ) {
            return abort( 401 );
        }

        $item->delete();

        return redirect()->route( 'items.index' );
    }


    /**
     * numero di items richiesti da progetti aperti
     *
     * @param $item_id
     * @return mixed
     */
    private function getQtaFromProjects( $item_id )
    {
        return ItemProject::with( 'project' )
            ->where( 'item_id', $item_id )
            ->whereHas( 'project', function ( $q ) {
                $q->where( 'closed', 0 );
            } )
            ->sum( 'qta_req' );

    }


    private function getQtaFromMovements( $item_id )
    {
        return Movement::with( 'project' )
            ->where( 'item_id', $item_id )
            ->whereNotNull( 'project_id' )
            ->whereHas( 'project', function ( $q ) {
                $q->where( 'closed', 0 );
            } )
            ->sum( 'qta' );
    }

}
