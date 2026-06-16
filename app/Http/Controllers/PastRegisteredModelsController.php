<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\PastRegisteredModels;

class PastRegisteredModelsController extends Controller
{
    public function get_reward_models(int $category_id, int $year)
    {
        if ($category_id == 0 || $category_id == $this->emptyCartonClass() || $category_id == $this->emptyPlasticClass())
            $mustby = '!=';
        else
            $mustby = '=';

        $rewards = PastRegisteredModels::join('categories', 'categories_id', '=', 'idkat')
            ->join('users', 'user_id', 'users.id')
            ->select(
                'past_registered_models.*',
                'categories.klasa',
                'categories.symbol',
                'categories.nazwa as categoryName',
                'users.imie',
                'users.nazwisko',
                DB::raw('IF (past_registered_models.wynik < 4, "DYPLOM", "WYRÓŻNIENIE") as typeName'),
                DB::raw('IF (past_registered_models.wynik = 1, "pierwsze", 
                          IF (past_registered_models.wynik = 2, "drugie", 
                          IF (past_registered_models.wynik = 3, "trzecie",
                          IF (past_registered_models.wynik = 4, "wyróżnienie", "")))) as place')
            )
            ->where('categories_id', $mustby, $category_id)
            ->where('past_registered_models.year', $year)
            ->where('users.rokur', '<=', ($year - 18))
            ->orderBy('categories.klasa', 'asc')
            ->orderBy('categories.symbol', 'asc')
            ->orderByRaw('FIELD(wynik, 1, 2, 3, 4, 0)')
            ->orderBy('users.nazwisko', 'asc')
            ->orderBy('users.imie', 'asc')
            ->get();

        return response()->json([
            'status' => 200,
            'rewards' => $rewards
        ]);
    }

    public function get_years()
    {
        $years = PastRegisteredModels::distinct()->orderBy('year', 'desc')->pluck('year')->toArray();
        $currentYear = $this->maxYear();

        if (!in_array($currentYear, $years)) {
            array_unshift($years, $currentYear);
        }

        return response()->json([
            'status' => 200,
            'years' => $years
        ]);
    }
}