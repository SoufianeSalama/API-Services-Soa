<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * De ROUTE view, die een kaart (HereMaps Api) toont met locaties van klanten
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('route.index');
    }
}
