<?php

namespace App\Http\Controllers;

/* Requests */
use Illuminate\Http\Request;
use App\Http\Requests\Feedback;

/* Jobs */
use App\Jobs\Emails\SendFeedbackEmail;

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
     * Show the about page.
     *
     * @return \Illuminate\Http\Response
     */
    public function about()
    {
        $team_members = [
            (object) [
                'photo_link' => '/imgs/mike-headshot.jpg',
                'name' => 'Mike Buss',
                'role' => 'Design',
                'link' => 'https://www.linkedin.com/in/mike-buss-a764bb54/'
            ],
            (object) [
                'photo_link' => '/imgs/dave-headshot.png',
                'name' => 'David Buss',
                'role' => 'Builder',
                'link' => 'https://github.com/kotarCreative'
            ],
        ];

        return view('about', compact('team_members'));
    }

    /**
     * Show the privacy policy page.
     *
     * @return \Illuminate\Http\Response
     */
    public function privacy()
    {
        return view ('privacy');
    }

    /**
     * Send feedback message to admin.
     *
     * @param App\Http\Requests\Feedback $request
     *
     * @return \Illuminate\Http\Response
     */
    public function sendFeedback(Feedback $request)
    {
        dispatch(new SendFeedbackEmail($request->name, $request->issue, $request->respond, $request->comments, $request->email));

        return response()->json([
            'session' => 'Feedback Sent!'
        ]);
    }
}
