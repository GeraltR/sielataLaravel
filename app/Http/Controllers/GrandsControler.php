<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Grands;

class GrandsControler extends Controller
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
        $request->validate([
            'users_id' => ['required', 'integer'],
            'categories_id' => ['required', 'integer'],
            'id' => ['required', 'integer'],
            'prixes_id' => ['required', 'integer']
        ]);

        $grand_prix = Grands::create([
            'users_id' => $request->users_id,
            'categories_id' => $request->categories_id,
            'model_id' => $request->id,
            'prixes_id' => $request->prixes_id
        ]);

        $last_id = $grand_prix;
        return $last_id;
    }

    public function get_list(Request $response)
    {
        $maxYear = $this->maxYear();

        $list_grandprixes =  Grands::join('users', 'users_id', 'users.id')
            ->join('categories', 'categories_id', 'idkat')
            ->join('registered_models', 'model_id', 'registered_models.id')
            ->join('grand_prixes', 'prixes_id', 'grand_prixes.id')
            ->select(
                'grands.*',
                'grand_prixes.prix_name',
                'grand_prixes.information',
                'registered_models.nazwa as modelName',
                'registered_models.konkurs',
                'categories.klasa',
                'categories.symbol',
                'categories.nazwa as categoryName',
                'users.imie',
                'users.nazwisko',
                'users.miasto',
                'users.klub',
                'users.rokur',
                DB::raw('IF (users.rokur <= ' . ($maxYear - 18) . ', "Senior", IF (users.rokur > ' . ($maxYear - 14) . ', "Młodzik", "Junior")) AS kategoriaWiek')
            )
            ->orderBy('grands.id', 'DESC')
            ->get();
        return response()->json([
            'status' => 200,
            'grandprixes' => $list_grandprixes
        ]);
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
