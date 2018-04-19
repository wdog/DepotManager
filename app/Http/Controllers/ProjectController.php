<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\StoreItemProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Item;
use App\ItemProject;
use App\Movement;
use App\Project;
use App\Utils\ItemProjectDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use ViewComponents\Eloquent\EloquentDataProvider;
use ViewComponents\Grids\Component\Column;
use ViewComponents\Grids\Component\ColumnSortingControl;
use ViewComponents\Grids\Component\CsvExport;
use ViewComponents\Grids\Component\DetailsRow;
use ViewComponents\Grids\Grid;
use ViewComponents\ViewComponents\Component\Control\PageSizeSelectControl;
use ViewComponents\ViewComponents\Component\Control\PaginationControl;
use ViewComponents\ViewComponents\Component\ManagedList\RecordView;
use ViewComponents\ViewComponents\Customization\CssFrameworks\BootstrapStyling;
use ViewComponents\ViewComponents\Data\ArrayDataProvider;
use ViewComponents\ViewComponents\Input\InputSource;

/**
 * Class ProjectController
 *
 * @package App\Http\Controllers
 */
class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if ( !Gate::allows( 'projects_manage' ) ) {
            return abort( 401 );
        }

        $provider = new EloquentDataProvider( Project::orderBy( 'closed' ) );
        $input = new InputSource( $_GET );

        $columns = [
            ( new Column( 'name', trans( 'global.name' ) ) )
                ->setValueFormatter( function ( $val, $row ) {

                    if ( $row->closed == true ) {
                        $rs = "<del class='text-danger'>" . $row->name . "</del>";
                    } else {
                        $rs = $row->name;
                    }

                    return $rs;
                } ),
            // GOUPS
            ( new Column( 'groups', trans( 'global.groups.title' ) ) )
                ->setValueFormatter( function ( $groups ) {
                    $rs = "";
                    foreach ( $groups as $group ) {
                        $rs .= "<span class='badge badge-info'>" .  $group->name. "</span> ";
                    }
                    return $rs;
                } ),
            //  ACTIONS
            ( new Column( 'actions', '' ) )
                ->setValueCalculator( function ( $row ) {
                    $edit = link_to_route( 'projects.edit', '', $row->id, [ 'class' => 'btn btn-sm btn-info fa fa-pencil' ] );
                    $delete = link_to_route( 'projects.destroy', '', $row->id, [
                        'class'        => 'btn btn-danger btn-sm fa fa-trash',
                        'data-method'  => "delete",
                        'data-confirm' => "Are you sure?",
                    ] );
                    $view = link_to_route( 'projects.show', '', $row->id, [ 'class' => 'btn btn-sm btn-success fa fa-eye' ] );
                    $buttons = $view . " " . $edit . " " . $delete;
                    return $buttons;
                } ),
            new PageSizeSelectControl( $input->option( 'ps', 50 ), [ 10, 50, 100, 500 ] ),
            new PaginationControl( $input->option( 'page', 1 ), 5 ),
            new ColumnSortingControl( 'name', $input->option( 'sort' ) ),
        ];


        $grid = new Grid( $provider, $columns );

        BootstrapStyling::applyTo( $grid );
        $grid->getColumn( 'actions' )->getDataCell()->setAttribute( 'class', 'fit-cell' );
        $grid->getTileRow()->detach()->attachTo( $grid->getTableHeading() );

        return view( 'projects.index', compact( 'grid' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if ( !Gate::allows( 'projects_manage' ) ) {
            return abort( 401 );
        }
        $groups = Group::pluck( 'name', 'id' );
        return view( 'projects.create', compact( 'groups' ) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return Response
     */
    public function store( Request $request )
    {
        if ( !Gate::allows( 'projects_manage' ) ) {
            return abort( 401 );
        }
        $project = Project::create( $request->all() );
        $project->groups()->sync( $request->group_id );
        return redirect()->route( 'projects.index' );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project $project
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show( Project $project )
    {
        if ( !Gate::allows( 'projects_manage' ) ) {
            return abort( 401 );
        }

        $list = $project->movements()->groupBy( 'item_id' )->selectRaw( ' sum(qta) as qta, item_id' )->pluck( 'qta', 'item_id' );
        // items movimentati ma non contemplati nel progetto
        $missings = Movement::with( 'item' )
            ->where( 'project_id', $project->id )
            ->whereNotIn( 'item_id', ItemProject::where( 'project_id', $project->id )->pluck( 'item_id' ) )
            ->get();

        $input = new InputSource( $_GET );
        $provider = new ArrayDataProvider( $project->items );
        $columns = [
            new Column( 'code', trans( 'global.code' ) ),
            new Column( 'name', trans( 'global.items.title' ) ),
            new Column( 'pivot.qta_req', trans( 'global.qta' ) ),
            ( new Column( 'usage', 'Usage ' ) )->setValueFormatter( function ( $val, $row ) use ( $list ) {
                if ( isset( $list[ $row->id ] ) )
                    return -1 * $list[ $row->id ];
                else
                    return 0;

            } ),
            new DetailsRow( new ItemProjectDetail() ),
            new CsvExport( $input->option( 'csv' ) ),

        ];
        $grid = new Grid( $provider, $columns );
        BootstrapStyling::applyTo( $grid );
        $grid->getColumn( 'code' )->getDataCell()->setAttribute( 'class', 'text-right fit-cell' );
        $grid->getColumn( 'pivot.qta_req' )->getDataCell()->setAttribute( 'class', 'text-right fit-cell' );
        $grid->getColumn( 'usage' )->getDataCell()->setAttribute( 'class', 'text-right fit-cell' );
        // filter on top of table
        $grid->getTileRow()->detach()->attachTo( $grid->getTableHeading() );

        $row = $grid->getTableBody()->getChildrenRecursive()->findByProperty( 'tag_name', 'tr', true );
        $row->setAttribute( 'class', 'bg-navy text-light' );
        return view( 'projects.view', compact( 'project', 'grid', 'missings' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project $project
     * @return Response
     */
    public function edit( Project $project )
    {
        if ( !Gate::allows( 'projects_manage' ) ) {
            return abort( 401 );
        }
        $groups = Group::pluck( 'name', 'id' );
        return view( 'projects.edit', compact( 'project', 'groups' ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProjectRequest $request
     * @param  \App\Project $project
     * @return Response
     */
    public function update( UpdateProjectRequest $request, Project $project )
    {
        if ( !Gate::allows( 'projects_manage' ) ) {
            return abort( 401 );
        }
        $project->setAttribute( 'closed', ( $request->has( 'closed' ) ) ? true : false );
        $project->update( $request->all() );

        $project->groups()->sync( $request->group_id );
        return redirect()->route( 'projects.index' );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function destroy( $id )
    {
        if ( !Gate::allows( 'projects_manage' ) ) {
            return abort( 401 );
        }
        $project = Project::findOrFail( $id );
        $project->delete();
        return redirect()->route( 'projects.index' );
    }


    /**
     * @param Project $project
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function addItem( Project $project )
    {
        if ( !Gate::allows( 'projects_manage' ) ) {
            return abort( 401 );
        }
        $items = Item::enabled()->get()->pluck( 'full_name', 'id' );
        return view( 'projects.items.add', compact( 'project', 'items' ) );
    }

    /**
     * ADMIN LOADS AN ITEM
     *
     * @param StoreItemProjectRequest $request
     * @param Project $project
     * @return string
     */
    public function storeItem( StoreItemProjectRequest $request, Project $project )
    {
        if ( !Gate::allows( 'projects_manage' ) ) {
            return abort( 401 );
        }

        if ( $project->items()->where( 'item_id', $request->item_id )->exists() ) {
            ItemProject::where( [ 'item_id' => $request->item_id, 'project_id' => $project->id ] )
                ->increment( 'qta_req', $request->qta_req );
        } else {
            $project->items()->attach( $request->item_id, [ 'qta_req' => $request->qta_req ] );
        }
        return redirect()->route( 'projects.show', $project );
    }


    /**
     * @param Request $request
     * @param Project $project
     * @return string
     */
    public function addMissing( Request $request, Project $project )
    {
        $missings = Movement::with( 'item' )
            ->where( 'project_id', $project->id )
            ->whereNotIn( 'item_id', ItemProject::where( 'project_id', $project->id )->pluck( 'item_id' ) )
            ->get();

        foreach ( $missings as $missing ) {
            $project->items()->attach( $missing->item );
        }

        return redirect()->route( 'projects.show', $project );
    }
}
