<?php

namespace App\Http\Controllers;

use App\Models\Planogram;
use Illuminate\Http\Request;

class PlanogramController extends Controller
{
    public function list()
    {
        return view('planogram.admin', ['planograms' => Planogram::orderBy('created_at', 'desc')->get()]);
    }
}
