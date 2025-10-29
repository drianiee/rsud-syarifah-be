<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parkir;
use App\Models\ParkingSetting;

class ParkirController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->integer('month');
        $year  = $request->integer('year');

        $q = Parkir::query();
        if ($year)  $q->where('tahun', $year);
        if ($month) $q->where('bulan', $month);

        return response()->json($q->orderBy('tanggal')->get());
    }

    public function store(Request $request)
    {
        $v = $request->validate([
            'tanggal'        => 'required|date',
            'shift'          => 'required|string',
            'pendapatan_r2'  => 'required|integer|min:0',
            'pendapatan_r4'  => 'required|integer|min:0',
        ]);

        $setting = ParkingSetting::query()->firstOrFail();

        $jumlahR2 = $setting->r2_price > 0 ? intdiv($v['pendapatan_r2'], $setting->r2_price) : 0;
        $jumlahR4 = $setting->r4_price > 0 ? intdiv($v['pendapatan_r4'], $setting->r4_price) : 0;


        $dt    = new \DateTime($v['tanggal']);
        $bulan = (int)$dt->format('n');
        $tahun = (int)$dt->format('Y');

        $parkir = Parkir::create([
            'tanggal'        => $v['tanggal'],
            'shift'          => $v['shift'],
            'pendapatan_r2'  => $v['pendapatan_r2'],
            'pendapatan_r4'  => $v['pendapatan_r4'],
            'jumlah_r2'      => $jumlahR2,
            'jumlah_r4'      => $jumlahR4,
            'total'          => $v['pendapatan_r2'] + $v['pendapatan_r4'],
            'bulan'          => $bulan,
            'tahun'          => $tahun,
        ]);

        return response()->json($parkir, 201);
    }

    public function destroy(Parkir $parkir)
    {
        $parkir->delete();
        return response()->json(['message' => 'deleted']);
    }
}
