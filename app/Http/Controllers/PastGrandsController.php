<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\PastGrands;

class PastGrandsController extends Controller
{
    public function get_list(Request $request, $order, $year)
    {
        if ($order == 0) {
            $direct = 'DESC';
            $order_field = 'past_grands.id';
        } else {
            $direct = 'ASC';
            $order_field = 'grand_prixes.id';
        }

        $list_grandprixes = PastGrands::join('users', 'users_id', 'users.id')
            ->join('categories', 'categories_id', 'idkat')
            ->join('registered_models', 'model_id', 'registered_models.id')
            ->join('grand_prixes', 'prixes_id', 'grand_prixes.id')
            ->select(
                'past_grands.*',
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
                DB::raw('IF (users.rokur <= ' . ($year - 18) . ', "Senior", IF (users.rokur > ' . ($year - 14) . ', "Młodzik", "Junior")) AS kategoriaWiek')
            )
            ->where('past_grands.year', $year)
            ->orderBy($order_field, $direct)
            ->get();

        return response()->json([
            'status' => 200,
            'grandprixes' => $list_grandprixes
        ]);
    }
}
