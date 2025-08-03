<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegisteredModels;
use App\Models\User;

class RegisteredModelsController extends Controller
{

    public function get_statistics()
    {
        $maxYear = $this->maxYear();

        //count all models
        $sumAllModels = RegisteredModels::count();

        //count category carton
        $sumCarton = RegisteredModels::join('categories', 'categories_id', '=', 'idkat')
            ->where('categories.klasa', 'K')
            ->count();

        //count category plastic
        $sumPlastic = RegisteredModels::join('categories', 'categories_id', '=', 'idkat')
            ->where('categories.klasa', 'P')
            ->count();

        //count all users with registered models
        $sumAllContestant = User::whereRaw('EXISTS (SELECT 1 FROM registered_models where registered_models.users_id=users.id)')
            ->count();

        //count Senior
        $ageBegin = 1900;
        $ageEnd = $maxYear - 18;
        $sumSenior = User::whereBetween('users.rokur', [$ageBegin, $ageEnd])
            ->whereRaw('EXISTS (SELECT 1 FROM registered_models where registered_models.users_id=users.id)')
            ->count();

        //count Junior
        $ageBegin = $maxYear - 17;
        $ageEnd = $maxYear - 14;
        $sumJunior = User::whereBetween('users.rokur', [$ageBegin, $ageEnd])
            ->whereRaw('EXISTS (SELECT 1 FROM registered_models where registered_models.users_id=users.id)')
            ->count();

        //count Youngster
        $ageBegin = $maxYear - 13;
        $ageEnd = $maxYear;
        $sumYoung = User::whereBetween('users.rokur', [$ageBegin, $ageEnd])
            ->whereRaw('EXISTS (SELECT 1 FROM registered_models where registered_models.users_id=users.id)')
            ->count();

        $wynik = array(
            "sumAllModels" => $sumAllModels,
            "sumAllContestant" => $sumAllContestant,
            "sumCarton" => $sumCarton,
            "sumPlastic" => $sumPlastic,
            "sumSenior" => $sumSenior,
            "sumJunior" => $sumJunior,
            "sumYoung" => $sumYoung
        );

        return response()->json([
            'statistics' => $wynik
        ]);
    }

    //Geting list of registered teenager
    public function get_list_registered_teenager()
    {
        $ageBegin = $this->maxYear() - 17;
        $ageEnd = $this->maxYear();
        $list = User::whereBetween('users.rokur', [$ageBegin, $ageEnd])
            ->select(
                'users.id',
                'users.imie',
                'users.nazwisko',
                DB::raw('"WYRÓŻNIENIE" as typeName')
            )
            ->whereRaw('EXISTS (SELECT 1 FROM registered_models where registered_models.users_id=users.id)')
            ->orderBy('users.nazwisko', 'asc')
            ->orderBy('users.imie', 'asc')
            ->get();
        return response()->json([
            'status' => 200,
            'users' => $list
        ]);
    }


    public function get_list_models($idclass, $id, $age, $name)
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
                    $ageBegin = $maxYear - 17;
                    $ageEnd  = $maxYear - 14;
                    break;
                    //Mlodzik i Junior
                case 3:
                    $ageBegin = $maxYear - 17;
                    $ageEnd = $maxYear;
                    break;
                    //Senior
                case 4:
                    $ageBegin = 1900;
                    $ageEnd = $maxYear - 18;
                    break;
                    //Młodzik i Senior
                case 5:
                    $ageBegin = 1900;
                    $ageEnd = $maxYear;
                    $notAgeBegin = $maxYear - 17;
                    $notAgeEnd = $maxYear - 13;
                    break;
                    //Junior i Senior
                case 6:
                    $ageBegin = 1900;
                    $ageEnd = $maxYear - 13;
                    break;
            }
        }

        if ($name != '&') {
            $fieldname = 'registered_models.nazwa';
            $fieldnumber = 'registered_models.konkurs';
            $mustbyname = 'like';
            $valuename = "%$name%";
        } else {
            $fieldname = 'users.id';
            $fieldnumber = 'categories_id';
            $mustbyname = '>=';
            $valuename = 0;
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
            ->where(function ($query) use ($fieldname, $fieldnumber, $mustbyname, $valuename) {
                $query->where($fieldname, $mustbyname, $valuename)
                    ->orWhere($fieldnumber, $mustbyname, $valuename);
            })
            ->orderBy('registered_models.id')
            ->get();
        return response()->json([
            'status' => 200,
            'models' => $models
        ]);
    }

    public function get_list2points($category, $userid)
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

    /*This is the final of the sql sentence
        WITH model_points AS 
        (SELECT registered_models.*, 
                users.imie, 
                users.nazwisko, 
                (SELECT IFNULL(SUM(points),0) FROM models_ratings WHERE models_ratings.model_id = registered_models.id) AS total,
                (SELECT IFNULL(SUM(flaga),0) FROM models_ratings WHERE registered_models.id = models_ratings.model_id) AS flaga 
        FROM registered_models INNER JOIN users ON users_id = users.id 
        WHERE categories_id = 23 AND users.rokur < 2008 ) 
        SELECT *, 
               DENSE_RANK() OVER (ORDER BY total DESC) AS place, 
               DENSE_RANK() OVER (ORDER BY flaga ASC) AS prefer 
        FROM model_points; 
    */
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
        $subQuery = DB::table('registered_models')
                    ->select(
                        'registered_models.*',
                        'users.imie',
                        'users.nazwisko',
                        DB::raw('(SELECT IFNULL(SUM(points),0) FROM models_ratings WHERE models_ratings.model_id = registered_models.id) as total'),
                        DB::raw('(SELECT IFNULL(SUM(flaga),0) FROM models_ratings WHERE registered_models.id = models_ratings.model_id) as flaga')
                    )
                    ->join('users', 'registered_models.users_id', '=', 'users.id')
                    ->where($field, '=', $value)
                    ->where('users.rokur', '<', $olderYear);

        $models = DB::table(DB::raw("({$subQuery->toSql()}) as model_points"))
                  ->mergeBindings($subQuery) // ważne aby przekazać bindings
                  ->selectRaw('*, DENSE_RANK() OVER(ORDER BY total DESC) as place, DENSE_RANK() OVER(ORDER BY flaga ASC) as prefer')
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

    public function get_models_in_category($category)
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

    public function get_twocategories($categoriesA, $categoriesB)
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

    public function connect_category($categoriesA, $categoriesB)
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

    public function print_models($id)
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

    //Geting list of models for user
    public function get_models($id)
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

    //Geting list of reward a models
    public function get_reward_models($category_id)
    {
        try {
            $isAdmin = auth()->user()->admin;
        } catch (\Throwable $th) {
            $isAdmin = 0;
        }

        if ($category_id == 0 || $category_id == $this->emptyCartonClass() || $category_id == $this->emptyPlasticClass())
            $mustby = '!=';
        else
            $mustby = '=';
        $rewards = RegisteredModels::join('categories', 'categories_id', '=', 'idkat')
            ->join('users', 'users_id', 'users.id')
            ->select(
                'registered_models.*',
                'categories.klasa',
                'categories.symbol',
                'categories.nazwa as categoryName',
                'users.imie',
                'users.nazwisko',
                DB::raw('IF (registered_models.wynik < 4, "DYPLOM", "WYRÓŻNIENIE") as typeName'),
                DB::raw('IF (registered_models.wynik = 1, "pierwsze", IF(registered_models.wynik = 2, "drugie", IF(registered_models.wynik = 3, "trzecie", "wyróżnienie"))) as place')
            )
            ->where('wynik', '!=', '0')
            ->where('categories_id', $mustby, $category_id)
            ->orderBy('categories.grupa', 'asc')
            ->orderBy('wynik', 'asc')
            ->get();
        return response()->json([
            'status' => 200,
            'rewards' => $rewards,
            'isadmin' => $isAdmin
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
            ->join('users', 'users_id', '=', 'id')
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

    public function delete_model($id)
    {
        RegisteredModels::findOrFail($id)->delete();
        return response()->noContent();
    }
}
