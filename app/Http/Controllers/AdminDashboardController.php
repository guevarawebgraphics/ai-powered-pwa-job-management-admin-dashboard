<?php

namespace App\Http\Controllers;

/**
 * Class AdminDashboardController
 * @package App\Http\Controllers
 * @author Randall Anthony Bondoc
 */
class AdminDashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin Dashboard Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles admin dashboard.
    |
    */

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
//        $this->middleware(['isAdmin']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.dashboard.index', compact([]));
    }
}
