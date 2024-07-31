<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegisteredModels;
use LDAP\Result;

class RegisteredModelsController extends Controller
{


    private function listModels($id)
    {
        if ($id != $this->emptyCartonClass() && $id != $this->emptyPlasticClass() && $id != 0)
            return RegisteredModels::where('categories_id', $id);
        else return RegisteredModels::all();
    }

    public function get_list_models(Request $request, $idclass, $id, $age, $name)
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
            ->addSelect(DB::raw($id . ' as id_jury'))
            ->addSelect(DB::raw("DENSE_RANK() OVER (PARTITION BY categories_id ORDER BY users_id) as atelier"))
            ->addSelect(DB::raw("(SELECT points FROM models_ratings where models_ratings.model_id = registered_models.id and judge_id = $id limit 1) as points"))
            ->addSelect(DB::raw("(SELECT flaga FROM models_ratings where models_ratings.model_id = registered_models.id and judge_id = $id limit 1) as flaga"))
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

    private function prepare_list_for_results($category)
    {
        $olderYear = $this->old_age_for_year();

        if ($category != 0 && $category != $this->emptyCartonClass() && $category != $this->emptyPlasticClass()) {
            $field = 'categories_id';
            $value = $category;
        } else {
            $field = '1';
            $value = '1';
        }
        $models = RegisteredModels::join('users', 'users_id', 'users.id')
            ->select('registered_models.*', 'users.imie', 'users.nazwisko')
            ->addSelect(DB::raw("(SELECT Sum(points) FROM models_ratings where models_ratings.model_id = registered_models.id) as total"))
            ->addSelect(DB::raw("(SELECT SUM(flaga) FROM models_ratings WHERE registered_models.id = models_ratings.model_id) AS flaga"))
            ->addSelect(DB::raw("DENSE_RANK() OVER(ORDER BY total DESC) AS place"))
            ->addSelect(DB::raw("DENSE_RANK() OVER(ORDER BY flaga ASC) AS prefer"))
            ->where($field, $value)
            ->where("users.rokur", '<', $olderYear)
            ->get();
        return $models;
    }

    private function make_results_in_category($category)
    {
        //update results for every models in category
        $result = $this->prepare_list_for_results($category);
        foreach ($result as $key => $model) {
            if ($model['total'] != 0) {
                $w = RegisteredModels::where("id", $model['id'])
                    ->update(["wynik" => $model['place']]);
            }
            if ($model['flaga'] != 0) {
                $w = RegisteredModels::where("id", $model['id'])
                    ->update(["wynik" => $model['place']]);
            }
        }
        return 1;
    }

    private function are_results_in_category($category)
    {
        //check is some one result for model in category
        $models = RegisteredModels::where("categories_id", $category)
            ->where("wynik", "!=",  0)
            ->whereNotNull("wynik")
            ->first();
        return $models;
    }

    public function get_models_in_category(Request $request, $category)
    {
        $calculate = $this->are_results_in_category($category);
        if ($calculate === null)
            $this->make_results_in_category($category);

        $models = $this->prepare_list_for_results($category);

        return response()->json([
            'status' => 200,
            'models' => $models
        ]);
    }

    public function save_rating(Request $request)
    {
        $saveRating = RegisteredModels::where("id", $request->model_id)
            ->update(["wynik" => $request->wynik]);
        return 1;
    }

    public function get_twocategories(Request $request, $categoriesA, $categoriesB)
    {
        $olderYear  = $this->maxYear() - 17;
        $models = RegisteredModels::join('users', 'users_id', 'users.id')
            ->select('registered_models.*')
            ->whereIn('categories_id', [$categoriesA, $categoriesB])
            ->where("users.rokur", '<', $olderYear)
            ->get();
        return response()->json([
            'status' => 200,
            'models' => $models
        ]);
    }

    public function connect_category(Request $request, $categoriesA, $categoriesB)
    {
        $olderYear  = $this->maxYear() - 17;
        $models = RegisteredModels::join('users', 'users_id', 'users.id')
            ->where('categories_id', $categoriesA)
            ->where('idparent', null)
            ->where("users.rokur", '<', $olderYear)
            ->update(['idparent' => $categoriesA]);
        $models = RegisteredModels::join('users', 'users_id', 'users.id')
            ->where('categories_id', $categoriesA)
            ->where('idparent', $categoriesA)
            ->where("users.rokur", '<', $olderYear)
            ->update(['categories_id' => $categoriesB]);
        return 1;
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
