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

    /**
     * Show the about page.
     *
     * @return \Illuminate\Http\Response
     */
    public function about()
    {
        $team_members = [
            (object) [
                'photo_link' => '/imgs/dave-headshot.png',
                'name' => 'Mike Buss',
                'role' => 'Design',
                'link' => 'https://www.linkedin.com/in/mike-buss-a764bb54/'
            ],
            (object) [
                'photo_link' => '/imgs/dave-headshot.png',
                'name' => 'Dave Buss',
                'role' => 'Builder',
                'link' => 'https://github.com/kotarCreative'
            ],
        ];

        return view('about', compact('team_members'));
    }
}
