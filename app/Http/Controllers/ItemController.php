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
use Illuminate\Support\Facades\Input;
use ViewComponents\Eloquent\EloquentDataProvider;
use ViewComponents\Grids\Component\Column;
use ViewComponents\Grids\Component\CsvExport;
use ViewComponents\Grids\Component\DetailsRow;
use ViewComponents\Grids\Grid;
use ViewComponents\ViewComponents\Component\Control\FilterControl;
use ViewComponents\ViewComponents\Component\Control\PageSizeSelectControl;
use ViewComponents\ViewComponents\Component\Control\PaginationControl;
use ViewComponents\ViewComponents\Component\Html\Tag;
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

        $columns = [
            new FilterControl( 'code', FilterOperation::OPERATOR_STR_CONTAINS, $input->option( 'code' ) ),
            //new SelectFilterControl( 'um', Helpers::ComboUnita(), $input->option( 'um' ) ),

            new Column( 'code', trans( 'global.code' ) ),
            new Column( 'name', trans( 'global.name' ) ),
            ( new Column( 'qta', trans( 'global.qta' ) ) )->setValueCalculator( function ( $row ) {
                return $row->available();
            } ),


            ( new Column( 'req', trans( 'global.qta_needs' ) ) )->setValueCalculator( function ( $row ) {

                $req_projects = $this->getQtaFromProjects( $row->id );
                $unloaded = $this->getQtaFromMovements( $row->id );
                $val = $req_projects + $unloaded - $row->available();

                if ( -1 * $val > $row->available() ) {
                    return "<span class='badge-warning badge'>Anomalie</span>";
                }

                $style = ( $val >= 0 ) ? 'danger' : 'primary';
                $val = ( $val < 0 ) ? -1 * $val : $val;
                return "<span class='badge-$style badge'>$val</span>";

            } ),

            ( new Column( 'actions', '' ) )
                ->setValueCalculator( function ( $row ) {
                    $edit = link_to_route( 'items.edit', '', $row->id, [
                        'class' => 'btn btn-sm btn-info fa fa-pencil',
                        'data-toggle'    => "tooltip",
                        'data-placement' => "top",
                        'title'          => "Edit Info",
                    ] );


                    $delete = link_to_route( 'items.destroy', '', $row->id, [
                        'class'          => 'btn btn-sm btn-danger fa fa-trash',
                        'data-method'    => "delete",
                        'data-confirm'   => "Are you sure?",
                        'data-toggle'    => "tooltip",
                        'data-placement' => "top",
                        'title'          => "Delete",

                    ] );

                    $view = "<a class='openImage btn btn-success btn-sm fa'
                                data-toggle    = 'tooltip'
                                data-placement = 'top'
                                title          = 'Show Image' 
                                data-code='{$row->code}'
                                data-url='{$row->item_image->profile->url}'
                                data-toggle='modal' 
                                data-target='#itemImage'><i class='fa fa-image'></i></a>";

                    $info = link_to_route( 'items.project', '', $row->id, [
                        'class'          => 'btn btn-sm btn-warning fa fa-product-hunt',
                        'data-toggle'    => "tooltip",
                        'data-placement' => "top",
                        'title'          => "Projects with Item",
                    ] );
                    return $edit . " " . $delete . " " . $view . " " . $info;
                } ),

            new DetailsRow( new ItemDetail() ),
            new PageSizeSelectControl( $input->option( 'ps', 50 ), [ 50, 100, 500 ] ),
            new PaginationControl( $input->option( 'page', 1 ), 5 ),

            new CsvExport( $input->option( 'csv' ) ),
        ];
        $grid = new Grid( $provider, $columns );

        // grid style
        BootstrapStyling::applyTo( $grid );
        // custom style
        $grid->getColumn( 'actions' )->getDataCell()->setAttribute( 'class', 'fit-cell' );
        $grid->getColumn( 'qta' )->getDataCell()->setAttribute( 'class', 'fit-cell text-right' );
        $grid->getColumn( 'req' )->getDataCell()->setAttribute( 'class', 'fit-cell text-right' );
        // filter on top of table
        $grid->getTileRow()->detach()->attachTo( $grid->getTableHeading() );

        $row = $grid->getTableBody()->getChildrenRecursive()->findByProperty( 'tag_name', 'tr', true );
        $row->setAttribute( 'class', 'bg-navy text-light' );
        $row->setAttribute( 'data-toggle', "tooltip" );
        $row->setAttribute( 'data-placement', "left" );
        $row->setAttribute( 'title', "Details" );
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


    /**
     * @param $item_id
     * @return mixed
     */
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


    /**
     * @param Item $item
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function projects( Item $item )
    {
        if ( !Gate::allows( 'items_manage' ) ) {
            return abort( 401 );
        }
        // mostro richieste di progetti aperti
        $item = ItemProject::with( 'project' )
            ->whereHas( 'project', function ( $q ) {
                $q->where( 'closed', 0 );
            } )
            ->where( 'item_id', $item->id );
        $provider = new EloquentDataProvider( $item );

        $grid = new Grid(
            $provider,
            [
                ( new Column( 'project.name' ) )->setLabel( trans( 'global.projects.title' ) ),
                ( new Column( 'qta_req' ) )->setLabel( trans( 'global.qta_needs' ) ),
                ( new Column( 'actions', '' ) )
                    ->setValueCalculator( function ( $row ) {
                        $view = link_to_route( 'projects.show', '', $row->project_id, [ 'class' => 'btn btn-sm btn-warning fa fa-product-hunt' ] );
                        return $view;
                    } ),
            ] );
        BootstrapStyling::applyTo( $grid );
        $grid->getColumn( 'qta_req' )->getDataCell()->setAttribute( 'class', 'fit-cell text-right' );
        $grid->getColumn( 'actions' )->getDataCell()->setAttribute( 'class', 'fit-cell text-right' );
        $row = $grid->getTableBody()->getChildrenRecursive()->findByProperty( 'tag_name', 'tr', true );
        $row->setAttribute( 'class', 'bg-navy text-light' );
        return view( 'items.projects', compact( 'grid' ) );
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function anomalies()
    {
        $anomalies = Movement::whereNotExists( function ( $q ) {
            $q->select( \DB::raw( 1 ) )
                ->from( 'item_project' )
                ->whereRaw( ' item_project.item_id = movements.item_id AND movements.project_id = item_project.project_id' );
        } )
            ->where( 'project_id', '>', '0' );

        $provider = new EloquentDataProvider( $anomalies );

        $grid = new Grid(
            $provider,
            [
                ( new Column( 'item.name' ) )->setLabel( trans( 'global.items.title' ) ),
                ( new Column( 'project.name' ) )->setLabel( trans( 'global.projects.title' ) ),
                ( new Column( 'user.name' ) )->setLabel( trans( 'global.users.title' ) ),
                ( new Column( 'group.name' ) )->setLabel( trans( 'global.groups.title' ) ),

                ( new Column( 'actions', '' ) )
                    ->setValueCalculator( function ( $row ) {
                        $view = link_to_route( 'projects.show', '', $row->project_id, [ 'class' => 'btn btn-sm btn-warning fa fa-product-hunt' ] );

                        return $view;
                    } ),
            ] );
        BootstrapStyling::applyTo( $grid );


        return view( 'items.anomalies', compact( 'grid' ) );
    }
}
