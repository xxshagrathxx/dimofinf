<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

class DashboardController extends Controller
{
    public function userLogout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
