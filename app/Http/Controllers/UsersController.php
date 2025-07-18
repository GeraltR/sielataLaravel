<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\RegisteredModels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Carbon\Carbon;


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
     * Show the form for finding name and surname user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function find($find)
    {
        $user = User::where();
    }

    public function short_update(Request $request, $id)
    {

        $user = User::findOrFail($id);

        $user->update([
            'imie' => $request->imie,
            'nazwisko' => $request->nazwisko,
            'email' => $request->email,
            'miasto' => $request->miasto,
            'rokur' => $request->rokur,
            'klub' => $request->klub,
            'admin' => $request->admin,
        ]);
        return $id;
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

        $user = User::findOrFail($id);
        $request->validate([
            'imie' => ['required', 'string', 'max:255'],
            'nazwisko' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'rokur' => ['required', 'integer', 'between:1900,' . $this->maxYear()],
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
            'data' => Carbon::now()->toDateTimeString(),
            'admin' => 0,
            'idopiekuna' => $request->idopiekuna,
            'isteacher' => $request->isteacher,
        ]);
        return $id;
    }

    public function change_teacher(Request $request, $id)
    {
        $user = User::findOrFail($id)->update(['isteacher' => $request->isteacher]);
        return 'isteacher ' . $id;
    }

    public function add_learner(Request $request, $id)
    {

        $request->validate([
            'imie' => ['required', 'string', 'max:255'],
            'nazwisko' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'rokur' => ['required', 'integer', 'between:1900,' . $this->maxYear()],
            'idopiekuna' => ['required', 'integer'],
            'miasto' => ['required', 'string', 'max:255'],
        ]);

        $learner = User::create([
            'imie' => $request->imie,
            'nazwisko' => $request->nazwisko,
            'email' => $request->email,
            'password' => "",
            'miasto' => $request->miasto,
            'rokur' => $request->rokur,
            'klub' => $request->klub,
            'idopiekuna' => $request->idopiekuna,
            'data' => Carbon::now()->toDateTimeString(),
            'status' => $request->status,
        ]);

        $last_id = $learner->id;
        return $last_id;
    }

    public function get_learners(Request $request, $id)
    {

        $idopiekuna = auth()->user()->id;
        if ($idopiekuna) {
            $learners = User::where('idopiekuna', $id)->get();
            return  response()->json([
                'status' => 200,
                'learners' => $learners
            ]);
        } else response()->json([
            'status' => 200,
            'learners' => []
        ]);
    }

    public function delete_learner(Request $request, $id)
    {
        $model = RegisteredModels::where('users_id', '=', $id)->first();
        if (!$model)
            User::findOrFail($id)->delete();
        return response()->noContent();
    }

    public function update_learner(Request $request, $id)
    {

        $learner = User::findOrFail($id);
        $request->validate([
            'imie' => ['required', 'string', 'max:255'],
            'nazwisko' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($learner->id)],
            'rokur' => ['required', 'integer', 'between:1900,' . $this->maxYear()],
            'idopiekuna' => ['required', 'integer'],
            'miasto' => ['required', 'string', 'max:255'],
        ]);

        $learner->update([
            'imie' => $request->imie,
            'nazwisko' => $request->nazwisko,
            'password' => "",
            'rokur' => $request->rokur,
            'miasto' => $request->miasto,
            'klub' => $request->klub,
            'data' => Carbon::now()->toDateTimeString(),
            'idopiekuna' => $request->idopiekuna,
            'status' => $request->status,
        ]);
        if ($request->status != 2)
            $learner->update(['email' => $request->email]);
        return $id;
    }

    //Geting users with registered models
    public function get_users_with_registered_models(Request $request, $find)
    {
        $list = User::whereRaw('users.nazwisko like "%' . $find . '%"')
            ->orderBy('users.nazwisko', 'asc')
            ->orderBy('users.imie', 'asc')
            ->orderBy('users.data', 'desc')
            ->get();
        return response()->json([
            'status' => 200,
            'users' => $list
        ]);
    }
}
