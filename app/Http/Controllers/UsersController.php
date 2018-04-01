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
        $this->middleware('auth')->except('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.show');
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
    public function edit()
    {
        $user = Auth::user();
        $user->references;
        $user->rentalHistory;
        $user->languages;
        if ($user->city) {
            $user->subdivision_id = $user->city->subdivision->id;
        }

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
            }

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

                    dispatch(new SendRentalHistoryApprovalEmail($user, $reference));
                }
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
}
