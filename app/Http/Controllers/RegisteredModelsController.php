<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\RegisteredModels;

class RegisteredModelsController extends Controller
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
    public function store(Request $request, $users_id, $categories_id)
    {
        $request->validate([
            'Nazwa' => ['required', 'string', 'max:150'],
            'Producent' => ['required', 'string', 'max:100'],
            'Skala' => ['required', 'string', 'max:100'],
            'users_id' => ['required', 'integer'],
            'categories_id' => ['required', 'integer']
        ]);

        $registered_model = RegisteredModels::create([
            'Nazwa' => $request->Nazwa,
            'Producent' => $request->Producent,
            'Skala' => $request->Skala,
            'users_id' => $request->users_id,
            'categories_id' => $request->categories_id
        ]);

        $last_id = $registered_model;
        return $last_id;
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
