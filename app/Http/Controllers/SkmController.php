<?php

namespace App\Http\Controllers;

use App\Models\Skm;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SkmController extends Controller
{
    public function index(Request $request)
    {
        $q = Skm::query()->orderBy('year')->orderBy('id');
        if ($request->filled('year')) {
            $q->where('year', (int)$request->year);
        }
        return response()->json($q->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'period_name'     => ['required','string','max:120'],
            'survey_period'   => ['required','string','max:120'],
            'male_count'      => ['required','integer','min:0'],
            'female_count'    => ['required','integer','min:0'],
            'index_value'     => ['required','numeric','between:0,10'],
            'service_quality' => ['required', Rule::in(['A','B','C'])],
            'performance'     => ['required','string','max:50'], 
            'ekm_value'       => ['required','numeric','between:0,100'],
            'year'            => ['required','integer','min:2000','max:2100'],
        ]);

        $row = Skm::create($data);
        return response()->json($row, 201);
    }

    public function destroy(Skm $skm)
    {
        $skm->delete();
        return response()->json(['message' => 'deleted']);
    }
}
