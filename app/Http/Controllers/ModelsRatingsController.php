<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ModelsRatings;

class ModelsRatingsController extends Controller
{

    public function set_points(Request $request, $user_id)
    {

        $wynik = ModelsRatings::where('model_id', $request->model_id)
            ->where('judge_id', $request->id_jury)
            ->exists();
        if (!$wynik) {
            DB::insert(
                'insert into models_ratings (points, flaga, model_id, judge_id) values (?, ?, ?, ?)',
                [$request->points, $request->flaga, $request->model_id, $request->id_jury]
            );
            $modelresult =  DB::getPdo()->lastInsertId();
        } else $modelresult = DB::update(
            'update models_ratings set points = ?, flaga = ? where model_id = ? and judge_id = ?',
            [$request->points, $request->flaga, $request->model_id, $request->id_jury]
        );

        return $modelresult;
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
