<?php


namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use Gate;

use App\Item;
use Illuminate\Http\Request;

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
        $items = \App\Item::paginate( 5 );
        return view( 'items.index', compact( 'items' ) );
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
        $item->update( $request->all() );
        return redirect()->route( 'items.index' );
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item $item
     * @return \Illuminate\Http\Response
     */
    public function destroy( Item $item )
    {
        //
    }
}
