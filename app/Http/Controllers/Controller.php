<?php

namespace App\Http\Controllers;

abstract class Controller
{
    //
    public function showDashboardPage() {
        return view('dashboard');
    }
}
