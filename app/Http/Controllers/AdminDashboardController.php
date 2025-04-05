<?php

namespace App\Http\Controllers;

use App\Models\Gig;
use App\Models\User;

/**
 * Class AdminDashboardController
 * @package App\Http\Controllers
 * @author Richard Guevara | Monte Carlo Web Graphics
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

        $gigs = Gig::with(['machine','client','technician'])->whereNull('deleted_at')->get();
        return view('admin.pages.dashboard.index', compact(['gigs']));
    }
}
