<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;


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
        return $id;
    }

    public function change_teacher(Request $request, $id)
    {
        $user = Users::findOrFail($id)->update(['isteacher' => $request->isteacher]);
        return 'isteacher ' . $id;
    }

    public function add_pupill(Request $request, $id)
    {
        $datetime = Carbon::now()->toDateTimeString();
        $maxYear = date('Y');

        $request->validate([
            'imie' => ['required', 'string', 'max:255'],
            'nazwisko' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'rokur' => ['required', 'integer', 'between:1900,' . $maxYear],
            'idopiekuna' => ['required', 'integer'],
            'miasto' => ['required', 'string', 'max:255'],
        ]);

        $pupill = Users::create([
            'imie' => $request->imie,
            'nazwisko' => $request->nazwisko,
            'email' => $request->email,
            'password' => "",
            'miasto' => $request->miasto,
            'rokur' => $request->rokur,
            'klub' => $request->klub,
            'idopiekuna' => $request->idopiekuna,
            'data' => $datetime,
        ]);

        $last_id = $pupill->id;
        return $last_id;
    }

    public function get_pupills(Request $request, $id)
    {

        $idopiekuna = auth()->user()->id;
        if ($idopiekuna) {
            $pupills = Users::where('idopiekuna', $id)->get();
            return  response()->json([
                'status' => 200,
                'pupills' => $pupills
            ]);
        } else response()->json([
            'status' => 200,
            'pupills' => []
        ]);
    }

    public function delete_pupill(Request $request, $id)
    {
        Users::findOrFail($id)->delete();
        return response()->noContent();
    }

    public function update_pupill(Request $request, $id)
    {
        $datetime = Carbon::now()->toDateTimeString();
        $maxYear = date('Y');

        $pupill = Users::findOrFail($id);
        $request->validate([
            'imie' => ['required', 'string', 'max:255'],
            'nazwisko' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($pupill->id)],
            'rokur' => ['required', 'integer', 'between:1900,' . $maxYear],
            'idopiekuna' => ['required', 'integer'],
            'miasto' => ['required', 'string', 'max:255'],
        ]);

        $pupill->update([
            'imie' => $request->imie,
            'nazwisko' => $request->nazwisko,
            'email' => $request->email,
            'password' => "",
            'rokur' => $request->rokur,
            'miasto' => $request->miasto,
            'klub' => $request->klub,
            'data' => $datetime,
            'idopiekuna' => $request->idopiekuna,
        ]);
        return $id;
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
