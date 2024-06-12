<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;


class UsersController extends Controller
{
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $datetime = Carbon::now()->toDateTimeString();
        $maxYear = date('Y');

        $user = Users::findOrFail($id);
        $request->validate([
            'imie' => ['required', 'string', 'max:255'],
            'nazwisko' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'rokur' => ['required', 'integer', 'between:1900,' . $maxYear],
            'miasto' => ['required', 'string', 'max:255'],
        ]);

        $user->update([
            'imie' => $request->imie,
            'nazwisko' => $request->nazwisko,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'miasto' => $request->miasto,
            'rokur' => $request->rokur,
            'klub' => $request->klub,
            'data' => $datetime,
            'admin' => 0,
            'idopiekuna' => $request->idopiekuna,
            'isteacher' => $request->isteacher,
        ]);
        return 'moje' . $id;
    }

    public function change_teacher(Request $request, $id)
    {
        $user = Users::findOrFail($id)->update(['isteacher' => $request->isteacher]);
        return 'isteacher ' . $id;
    }

    public function add_pupil(Request $request, $id)
    {
        return 'pupil_id';
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
