<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreAbilitiesRequest;
use App\Http\Requests\Admin\UpdateAbilitiesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Silber\Bouncer\Database\Ability;
use ViewComponents\Eloquent\EloquentDataProvider;
use ViewComponents\Grids\Component\Column;
use ViewComponents\Grids\Component\DetailsRow;
use ViewComponents\Grids\Grid;
use ViewComponents\ViewComponents\Customization\CssFrameworks\BootstrapStyling;
use ViewComponents\ViewComponents\Data\ArrayDataProvider;

class AbilitiesController extends Controller
{
    /**
     * Display a listing of Abilities.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( !Gate::allows( 'users_manage' ) ) {
            return abort( 401 );
        }

        $provider = new EloquentDataProvider( Ability::class );

        $columns = [
            new Column( 'title' ),
            new Column( 'name' ),

            ( new Column( 'actions', '' ) )
                ->setValueCalculator( function ( $row ) {

                    $edit = link_to_route( 'admin.abilities.edit', '', [ $row->id ], [ 'class' => 'btn btn-xs btn-info fa fa-pencil' ] );
                    $delete = link_to_route( 'admin.abilities.destroy', '', $row->id, [
                        'class'        => 'btn btn-xs btn-danger fa fa-trash',
                        'data-method'  => "delete",
                        'data-confirm' => "Are you sure?",

                    ] );
                    return $edit . " " . $delete;
                } ),

        ];

        $grid = new Grid( $provider, $columns );
        BootstrapStyling::applyTo( $grid );

        $grid->getColumn( 'actions' )->getDataCell()->setAttribute( 'class', 'fit-cell' );
        return view( 'admin.abilities.index', compact( 'grid' ) );
    }

    /**
     * Show the form for creating new Ability.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ( !Gate::allows( 'users_manage' ) ) {
            return abort( 401 );
        }
        return view( 'admin.abilities.create' );
    }

    /**
     * Store a newly created Ability in storage.
     *
     * @param  StoreAbilitiesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store( StoreAbilitiesRequest $request )
    {
        if ( !Gate::allows( 'users_manage' ) ) {
            return abort( 401 );
        }
        Ability::create( $request->all() );

        return redirect()->route( 'admin.abilities.index' );
    }


    /**
     * Show the form for editing Ability.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {
        if ( !Gate::allows( 'users_manage' ) ) {
            return abort( 401 );
        }
        $ability = Ability::findOrFail( $id );

        return view( 'admin.abilities.edit', compact( 'ability' ) );
    }

    /**
     * Update Ability in storage.
     *
     * @param  UpdateAbilitiesRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update( UpdateAbilitiesRequest $request, $id )
    {
        if ( !Gate::allows( 'users_manage' ) ) {
            return abort( 401 );
        }
        $ability = Ability::findOrFail( $id );
        $ability->update( $request->all() );

        return redirect()->route( 'admin.abilities.index' );
    }


    /**
     * Remove Ability from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id )
    {
        if ( !Gate::allows( 'users_manage' ) ) {
            return abort( 401 );
        }
        $ability = Ability::findOrFail( $id );
        $ability->delete();

        return redirect()->route( 'admin.abilities.index' );
    }

    /**
     * Delete all selected Ability at once. - NOT USED
     *
     * @param Request $request
     */
    public function massDestroy( Request $request )
    {
        if ( !Gate::allows( 'users_manage' ) ) {
            return abort( 401 );
        }
        if ( $request->input( 'ids' ) ) {
            $entries = Ability::whereIn( 'id', $request->input( 'ids' ) )->get();

            foreach ( $entries as $entry ) {
                $entry->delete();
            }
        }
    }

}
