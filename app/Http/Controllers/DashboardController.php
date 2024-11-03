<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function userProfile()
    {
        return view('pages.dashboard.profile-page');
    }
}