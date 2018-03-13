<?php


namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Utils\Helpers;
use Gate;

use App\Item;
use Illuminate\Http\Request;
use ViewComponents\Eloquent\EloquentDataProvider;
use ViewComponents\Grids\Component\AjaxDetailsRow;
use ViewComponents\Grids\Component\Column;
use ViewComponents\Grids\Component\DetailsRow;
use ViewComponents\Grids\Component\TableCaption;
use ViewComponents\Grids\Grid;
use ViewComponents\ViewComponents\Component\Control\FilterControl;
use ViewComponents\ViewComponents\Component\Control\PageSizeSelectControl;
use ViewComponents\ViewComponents\Component\Control\PaginationControl;
use ViewComponents\ViewComponents\Component\Control\SelectFilterControl;
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

        $provider = new EloquentDataProvider( Item::class );
        $input = new InputSource( $_GET );
        $grid = new Grid(
            $provider,
            // all components are optional, you can specify only columns
            [
                new TableCaption( 'Items' ),
                new Column( 'id' ),
                new Column( 'code' ),
                new FilterControl( 'code', FilterOperation::OPERATOR_STR_CONTAINS, $input->option( 'code' ) ),

                new Column( 'name' ),

                
                new SelectFilterControl( 'um', Helpers::ComboUnita(), $input->option( 'um' ) ),

                ( new Column( 'actions' ) )
                    ->setValueCalculator( function ( $row ) {
                        $edit = link_to_route( 'items.edit', 'Edit', $row->id, [ 'class' => 'btn btn-xs btn-info' ] );
                        $delete = link_to_route( 'items.destroy', 'Destroy', $row->id, [
                            'class'        => 'btn btn-xs btn-danger',
                            'data-method'  => "delete",
                            'data-confirm' => "Are you sure?",

                        ] );
                        return $edit . " " . $delete;
                    } ),

                new PaginationControl( $input->option( 'page', 1 ), 5 ),
                new PageSizeSelectControl( $input->option( 'ps', 4 ), [ 2, 4, 10, 100 ] ),

                new AjaxDetailsRow( function ( $row ) {
                    return route( 'items.show', $row->id );
                } ),
            ] );

        BootstrapStyling::applyTo( $grid );
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
     * @return \Illuminate\Http\RedirectResponse|void
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
     * @return Item|void
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
                new TableCaption( 'Detail' ),
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
     * @return \Illuminate\Http\Response
     */
    public function destroy( Item $item )
    {
        if ( !Gate::allows( 'items_manage' ) ) {
            return abort( 401 );
        }

        $item->delete();

        return redirect()->route( 'items.index' );
    }
}
