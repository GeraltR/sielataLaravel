<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GrandPrixes;
use App\Models\Grands;
use App\Models\PastGrands;

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
        $data = $request->validate([
            'prix_name' => ['required', 'string', 'max:255'],
            'information' => ['nullable', 'string', 'max:255'],
        ]);

        $prix = GrandPrixes::create([
            'prix_name' => $data['prix_name'],
            'information' => $data['information'] ?? '',
            'isActiv' => true,
        ]);

        return response()->json([
            'status' => 200,
            'prix' => $prix,
        ]);
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
        $prix = GrandPrixes::findOrFail($id);

        $data = $request->validate([
            'prix_name' => ['required', 'string', 'max:255'],
            'information' => ['nullable', 'string', 'max:255'],
            'isActiv' => ['required', 'boolean'],
        ]);

        $prix->update($data);

        return response()->json([
            'status' => 200,
            'prix' => $prix,
        ]);
    }

    /**
     * Check whether the given prize may be deleted, without deleting it.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkDeletable($id)
    {
        $prix = GrandPrixes::findOrFail($id);

        [$deletable, $reason] = $this->deletableState($prix);

        return response()->json([
            'status' => 200,
            'deletable' => $deletable,
            'reason' => $reason,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prix = GrandPrixes::findOrFail($id);

        [$deletable, $reason] = $this->deletableState($prix);

        if (!$deletable) {
            return response()->json([
                'status' => 422,
                'reason' => $reason,
                'message' => $this->reasonMessage($reason),
            ], 422);
        }

        $prix->delete();

        return response()->noContent();
    }

    /**
     * @return array{0: bool, 1: string|null}
     */
    private function deletableState(GrandPrixes $prix): array
    {
        if ($prix->isActiv) {
            return [false, 'active'];
        }

        $used = Grands::where('prixes_id', $prix->id)->exists()
            || PastGrands::where('prixes_id', $prix->id)->exists();

        if ($used) {
            return [false, 'used'];
        }

        return [true, null];
    }

    private function reasonMessage(?string $reason): string
    {
        return match ($reason) {
            'active' => 'Usunąć można tylko nieaktywne nagrody. Dezaktywuj nagrodę przed usunięciem.',
            'used' => 'Ta nagroda była już przyznana i nie można jej usunąć.',
            default => 'Nie można usunąć tej nagrody.',
        };
    }
}
