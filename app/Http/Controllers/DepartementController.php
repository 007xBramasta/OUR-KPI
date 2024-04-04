<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DepartementController extends Controller
{   
    public function get_departement(Request $request)
    {
        $departements = Departement::all()->map(function ($departement) {
            return [
                'departements_id' => $departement->departements_id,
                'departements_name' => $departement->departements_name,
            ];
        });

        return response()->json([
            'data' => $departements
        ]);
    }
}
