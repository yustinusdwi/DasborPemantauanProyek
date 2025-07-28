<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loi;

class LoiController extends Controller
{
    public function index()
    {
        $lois = Loi::with('kontrak')->orderBy('created_at', 'desc')->get();
        return view('loi', compact('lois'));
    }
} 