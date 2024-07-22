<?php

namespace App\Http\Controllers;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 * @author Randall Anthony Bondoc
 */
class FrontDashboardController extends Controller
{

    /**
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('front.pages.dashboard.index', compact([]));
    }
}
