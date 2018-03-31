<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the feedback page.
     *
     * @return \Illuminate\Http\Response
     */
    public function feedback()
    {
        return view('feedback');
    }

    /**
     * Show the unauthorized page.
     *
     * @return \Illuminate\Http\Response
     */
    public function forbidden()
    {
        return view('auth.403')->with('return', url()->previous());
    }
}
