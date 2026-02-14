<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LuongController extends Controller
{
    public function MonthlyView()
    {
        return view('salary.monthly');
    }

    public function ConfigView()
    {
        return view('salary.config');
    }

    public function DetailView()
    {
        return view('salary.detail');
    }
}
