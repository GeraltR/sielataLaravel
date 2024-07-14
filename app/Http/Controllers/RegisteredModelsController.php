<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegisteredModels;

class RegisteredModelsController extends Controller
{

    private function listModels($id)
    {
        if ($id != $this->emptyCartonClass() && $id != $this->emptyPlasticClass() && $id != 0)
            return RegisteredModels::where('categories_id', $id);
        else return RegisteredModels::all();
    }

    public function get_listModels(Request $request, $idclass, $id, $age, $name)
    {
        $maxYear = $this->maxYear();
        $agefield = 'users.rokur';
        $ageBegin = 1900;
        $ageEnd = $maxYear;
        $notAgeBegin = 0;
        $notAgeEnd = 0;

        if ($idclass != 0) {
            $field = 'categories.klasa';
            $mustby = '=';
            if ($idclass == 1)
                $idclass = 'K';
            else
                $idclass = 'P';
        } else {
            $field = 'users.id';
            $mustby = '>=';
        }
        if ($age != 0) {
            switch ($age) {
                    //Mlodzik
                case 1:
                    $ageBegin = $maxYear - 13;
                    $ageEnd = $maxYear;
                    break;
                    //Junior        
                case 2:
                    $ageBegin = $maxYear - 18;
                    $ageEnd  = $maxYear - 14;
                    break;
                    //Mlodzik i Junior        
                case 3:
                    $ageBegin = $maxYear - 18;
                    $ageEnd = $maxYear;
                    break;
                    //Senior 
                case 4:
                    $ageBegin = 1900;
                    $ageEnd = $maxYear - 19;
                    break;
                    //Młodzik i Senior
                case 5:
                    $ageBegin = 1900;
                    $ageEnd = $maxYear;
                    $notAgeBegin = $maxYear - 18;
                    $notAgeEnd = $maxYear - 13;
                    break;
                    //Junior i Senior   
                case 6:
                    $ageBegin = 1900;
                    $ageEnd = $maxYear - 13;
                    break;
            }
        }
        $models = RegisteredModels::join('categories', 'categories_id', '=', 'idkat')
            ->join('users', 'users_id', 'users.id')
            ->select(
                'registered_models.*',
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
            ->where($field, $mustby, $idclass)
            ->whereBetween($agefield, [$ageBegin, $ageEnd])
            ->whereNotBetween($agefield, [$notAgeBegin, $notAgeEnd])
            ->orderBy('registered_models.id')
            ->get();
        return response()->json([
            'status' => 200,
            'models' => $models
        ]);
    }

    public function get_list2points(Request $request, $category, $userid)
    {
        $maxYear = $this->maxYear();
        $id = auth()->user()->id;

        $models = RegisteredModels::join('users', 'users_id', 'users.id')
            ->select('registered_models.*')
            ->addSelect(DB::raw("DENSE_RANK() OVER (PARTITION BY categories_id ORDER BY users_id) as atelier"))
            ->addSelect(DB::raw("(SELECT Sum(points) FROM models_ratings where models_ratings.model_id = registered_models.id and judge_id = $id) as points"))
            ->addSelect(DB::raw("(SELECT Sum(points) FROM models_ratings where models_ratings.model_id = registered_models.id) as total"))
            ->where('users.rokur', '<=', ($maxYear - 18))
            ->where('categories_id', $category)
            ->orderBy('users_id', 'asc')
            ->orderBy('konkurs', 'asc')
            ->get();
        return response()->json([
            'status' => 200,
            'models' => $models
        ]);
    }

    public function set_points(Request $request, $id, $user_id)
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

        $registered_model = RegisteredModels::create([
            'nazwa' => $request->nazwa,
            'producent' => $request->producent,
            'skala' => $request->skala,
            'users_id' => $request->users_id,
            'categories_id' => $request->categories_id
        ]);

        $last_id = $registered_model;
        return $last_id;
    }

    private function setStartNumber($startId, $endId, $field, $mustby, $idclass)
    {

        $max = RegisteredModels::select(DB::raw('max(konkurs) as LP'))
            ->where('konkurs', '!=', '0')
            ->value('LP');

        if ($max === null)
            $max = 0;

        $models = RegisteredModels::join('categories', 'categories_id', '=', 'idkat')
            ->whereBetween('id', [$startId, $endId])
            ->where('konkurs', '=', '0')
            ->where($field, $mustby, $idclass)
            ->orderBy('id')
            ->get();

        $lp = $max + 1;
        foreach ($models as $a) {
            $t = RegisteredModels::findOrFail($a['id']);
            $t->update([
                "konkurs" => $lp
            ]);
            $lp = $lp + 1;
        }
    }

    public function print_models(Request $request, $id)
    {
        $maxYear = $this->maxYear();
        $pos = strPos($id, '-');
        $posKlasa = strPos($id, 'klasa=');
        if ($pos > 0) {
            $startId = substr($id, 0, $pos);
            $endId = substr($id, $pos + 1, $posKlasa - ($pos + 1));
        } else {
            $startId = $id;
            $endId = $id;
        }
        $idclass = substr($id, $posKlasa + 6);

        if ($idclass != 0) {
            $field = 'categories.klasa';
            $mustby = '=';
            if ($idclass == 1)
                $idclass = 'K';
            else
                $idclass = 'P';
        } else {
            $field = 'users_id';
            $mustby = '>=';
        }

        $this->setStartNumber($startId, $endId, $field, $mustby, $idclass);

        $models = RegisteredModels::whereBetween('registered_models.id', [$startId, $endId])
            ->join('categories', 'categories_id', '=', 'idkat')
            ->join('users', 'users_id', 'users.id')
            ->select(
                'registered_models.*',
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
            ->where($field, $mustby, $idclass)
            ->get();
        return response()->json([
            'status' => 200,
            'models' => $models
        ]);
    }

    public function get_models(Request $request, $id)
    {
        $models = RegisteredModels::where('users_id', $id)
            ->join('categories', 'categories_id', '=', 'idkat')
            ->select('registered_models.*', 'categories.klasa', 'categories.symbol', 'categories.nazwa as categoryName')
            ->get();
        return response()->json([
            'status' => 200,
            'models' => $models
        ]);
    }

    /**
     * Show the registered model with contestant and category filter.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function list_contestant($id)
    {
        $list = RegisteredModelsDB::where('categories_id', $id)
            ->join('categories', 'categories_id', '=', 'idkat')
            ->join('users', 'user_id', '=', 'id')
            ->select(
                'registered_models.*',
                'categories.klasa',
                'categories.symbol',
                'categories.nazwa as categoryName',
                'users.imie',
                'users.nazwisko',
                'users.miasto',
                'users.rokur'
            )
            ->get();
        return response()->json([
            'status' => 200,
            'listContestant' => $list
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_model(Request $request, $id)
    {
        $model = RegisteredModels::findOrFail($id);
        $request->validate([
            'nazwa' => ['required', 'string', 'max:150'],
            'users_id' => ['required', 'integer'],
            'categories_id' => ['required', 'integer']
        ]);
        $model->update([
            'nazwa' => $request->nazwa,
            'producent' => $request->producent,
            'skala' => $request->skala,
            'categories_id' => $request->categories_id,
        ]);
        return $id;
    }

    public function delete_model(Request $request, $id)
    {
        RegisteredModels::findOrFail($id)->delete();
        return response()->noContent();
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
