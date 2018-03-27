<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* Models */
use App\Models\Users\User;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Users\Store $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $user = new User();
        return DB::transaction(function() use ($request, $user) {
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();

            $user->assignRole($request->type);

            return response()->json([
                'session' => 'Profile Created',
                'user' => $user
            ]);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Models\Users\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
