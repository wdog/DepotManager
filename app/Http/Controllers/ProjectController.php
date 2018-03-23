<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\UpdateProjectRequest;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use ViewComponents\Eloquent\EloquentDataProvider;
use ViewComponents\Grids\Component\Column;
use ViewComponents\Grids\Grid;
use ViewComponents\ViewComponents\Component\Control\PageSizeSelectControl;
use ViewComponents\ViewComponents\Component\Control\PaginationControl;
use ViewComponents\ViewComponents\Customization\CssFrameworks\BootstrapStyling;
use ViewComponents\ViewComponents\Input\InputSource;

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

        $provider = new EloquentDataProvider( Project::class );
        $input = new InputSource( $_GET );
        $grid = new Grid(
            $provider, [
                ( new Column( 'name', trans( 'global.name' ) ) )->setValueFormatter( function ( $val, $row ) {

                    if ($row->closed == true){
                        $rs = "<del class='text-danger'>" .  $row->name . "</del>";
                    } else {
                        $rs = $row->name;
                    }

                    return $rs;
                } ),
                // GOUPS
                ( new Column( 'groups', trans( 'global.groups.title' ) ) )->setValueFormatter( function ( $groups ) {
                    $u = '';
                    foreach ( $groups as $group ) {
                        $u .= "<li class='list-group-item list-group-item-text list-group-item-info'>" . $group->name . "</li>";
                    }
                    return "<ul class='list-group'>" . $u . "</ul>";
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

                new PageSizeSelectControl( $input->option( 'ps', 4 ), [ 2, 4, 10, 100 ] ),
                new PaginationControl( $input->option( 'page', 1 ), 5 ),
            ]
        );

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
     * @return void
     */
    public function show( Project $project )
    {
        //
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
}
