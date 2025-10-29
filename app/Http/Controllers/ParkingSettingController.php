<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParkingSetting;

class ParkingSettingController extends Controller
{
    public function show()
    {
        $s = ParkingSetting::query()->firstOrFail();
        return response()->json($s);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'r2_price' => 'required|integer|min:0',
            'r4_price' => 'required|integer|min:0',
        ]);
        $s = ParkingSetting::query()->first();
        if (!$s) $s = new ParkingSetting();
        $s->fill($data)->save();

        return response()->json($s);
    }
}