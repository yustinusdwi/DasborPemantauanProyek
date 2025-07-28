<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminLandingController extends Controller
{
    /**
     * Display the admin landing page.
     */
    public function index(): View
    {
        return view('admin.landing');
    }
}
