<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoiController extends Controller
{
    public function index()
    {
        $lois = [];
        return view('loi', compact('lois'));
    }
} 