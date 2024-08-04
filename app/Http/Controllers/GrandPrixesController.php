<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GrandPrixes;

class GrandPrixesController extends Controller
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
            'nazwa' => ['required', 'string', 'max:150'],
            'users_id' => ['required', 'integer'],
            'categories_id' => ['required', 'integer']
        ]);

        $registered_model = GrandPrixes::create([
            'nazwa' => $request->nazwa,
            'producent' => $request->producent,
            'skala' => $request->skala,
            'users_id' => $request->users_id,
            'categories_id' => $request->categories_id
        ]);

        $last_id = $registered_model;
        return $last_id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $isActiv
     * @return \Illuminate\Http\Response
     */
    public function get_list_grand_prixes(Request $request, $isactiv)
    {
        if ($isactiv != 0) {
            $field = 'isActiv';
            $mustby = '=';
            $value = '1';
        } else {
            $field = 'id';
            $mustby = '>';
            $value = '0';
        }
        $prixes = GrandPrixes::where($field, $mustby, $value)
            ->select("grand_prixes.*", "grand_prixes.prix_name as name")
            ->orderBy("id")
            ->get();

        return response()->json([
            'status' => 200,
            'prixes' => $prixes
        ]);
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
