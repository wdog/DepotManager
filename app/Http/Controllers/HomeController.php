<?php

namespace App\Http\Controllers;

use App\Depot;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware( 'auth' );
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $depots = Depot::list()->get();
        $projects = Auth::user()->group->projects()->open()->get();

        return view( 'home', compact( 'depots', 'projects' ) );
    }


    /**
     * Locale switcher
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function switchLocale( Request $request, $locale )
    {
        if ( !empty( $locale ) ) {
            Session::put( 'locale', $locale );
        }
        return redirect( $request->header( "referer" ) );
    }
}
