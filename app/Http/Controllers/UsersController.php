<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Mail;
use Carbon\Carbon;

use App\Jobs\SendReferenceApprovalEmail;
use App\Jobs\SendRentalHistoryApprovalEmail;

/* Requests */
use Illuminate\Http\Request;
use App\Http\Requests\Users\Store;
use App\Http\Requests\Users\Update;

/* Models */
use App\Models\Users\User;
use App\Models\Users\Language;
use App\Models\Users\Reference;
use App\Models\Users\RentalHistory;
use App\Models\Users\ProfilePicture;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['store', 'approveReference']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('success') && $request->success == 'edit') {
            $request->session()->flash('success', 'Profile Updated!');
        }

        $user = Auth::user();
        $user->prepareShow();

        return view('users.show')->with('profile', $user);
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
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param  App\Models\Users\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        if ($request->has('success') && $request->success == 'edit') {
            $request->session()->flash('success', 'Profile Updated!');
        }

        $user->prepareShow();

        return view('users.show')->with('profile', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user();
        $user->prepareShow();

        return view('users.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Users\Update $request
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request)
    {
        $user = Auth::user();
        return DB::transaction(function() use ($request, $user) {
            $user->fill($request->all());

            $ref_ids = [];
            if ($request->references) {
                foreach ($request->references as $ref_info) {
                    if (isset($ref_info['id'])) {
                        $reference = Reference::find($ref_info['id']);
                        $reference->first_name = $ref_info['first_name'];
                        $reference->last_name = $ref_info['last_name'];
                        $reference->relationship = $ref_info['relationship'];
                        $reference->save();
                    } else {
                        $reference = new Reference();
                        $reference->user_id = $user->id;
                        $reference->first_name = $ref_info['first_name'];
                        $reference->last_name = $ref_info['last_name'];
                        $reference->email = $ref_info['email'];
                        $reference->relationship = $ref_info['relationship'];
                        $reference->email_token = base64_encode($ref_info['email'] . microtime());
                        $reference->save();

                        dispatch(new SendReferenceApprovalEmail($user, $reference));
                    }
                    $ref_ids[] = $reference->id;
                }
            }

            $user->references()->whereNotIn('id', $ref_ids)->delete();


            $rent_his_ids = [];
            if ($request->rental_history) {
                foreach ($request->rental_history as $history_info) {
                    if (isset($history_info['id'])) {
                        $history = RentalHistory::find($history_info['id']);
                        $history->started_on = Carbon::parse($history_info['started_on']);
                        $history->ended_on = Carbon::parse($history_info['ended_on']);
                        $history->landlord_first_name = $history_info['landlord_first_name'];
                        $history->landlord_last_name = $history_info['landlord_last_name'];
                        $history->save();
                    } else {
                        $history = new RentalHistory();
                        $history->user_id = $user->id;
                        $history->started_on = Carbon::parse($history_info['started_on']);
                        $history->ended_on = Carbon::parse($history_info['ended_on']);
                        $history->landlord_first_name = $history_info['landlord_first_name'];
                        $history->landlord_last_name = $history_info['landlord_last_name'];
                        $history->landlord_email = $history_info['landlord_email'];
                        $history->email_token = base64_encode($history_info['landlord_email'] . microtime());
                        $history->save();

                        dispatch(new SendRentalHistoryApprovalEmail($user, $history));
                    }
                    $rent_his_ids[] = $history->id;
                }
            }

            $user->rentalHistory()->whereNotIn('id', $rent_his_ids)->delete();

            // Save profile picture.
            if ($request->hasFile('profile_picture')) {
                $user->profilePictures()->update([ 'is_active' => false ]);
                $profile_pic = new ProfilePicture();
                $profile_pic->user_id = $user->id;
                $profile_pic->saveWithFile($request->file('profile_picture'));
            }

            $user->save();
            return response()->json([
                'message' => 'Profile Updated.'
            ]);
        });
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

    /**
     * Get all the languages available on the system.
     *
     * @return \Illuminate\Http\Response
     */
    public function languages()
    {
        $languages = Language::all();

        return response()->json([
            'languages' => $languages
        ]);
    }

    /**
     * Handle a reference approval.
     *
     * @param string $token
     * @param \Illuminate\Http\Request $requets
     * @return \Illuminate\Http\Response
     */
    public function approveReference($token, Request $request)
    {
        return DB::transaction(function() use ($token, $request) {
            $reference = Reference::where('email_token', $token)->first();
            $reference->verified = $request->approve;
            $message = 'Nicely done! Your reference will now be visibile to others.';
            if ($request->approve == 0) {
                $reference->denied_at = new Carbon();
                $message = 'Your reference request has been cancelled.';
            }
            if($reference->save()) {
                $request->session()->flash('success', $message);
                return redirect('/');
            }
        });
    }

    /**
     * Handle a rental history approval.
     *
     * @param string $token
     * @param \Illuminate\Http\Request $requets
     * @return \Illuminate\Http\Response
     */
    public function approveRentalHistory($token, Request $request)
    {
        return DB::transaction(function() use ($token, $request) {
            $rental_history = RentalHistory::where('email_token', $token)->first();
            $rental_history->verified = $request->approve;
            $message = 'Thanks for being used as a rental reference.';
            if ($request->approve == 0) {
                $rental_history->denied_at = new Carbon();
                $message = 'Your rental history request has been cancelled.';
            }
            if($rental_history->save()) {
                $request->session()->flash('success', $message);
                return redirect('/');
            }
        });
    }
}
