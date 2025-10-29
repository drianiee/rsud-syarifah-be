<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parkir;
use App\Models\ParkingSetting;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    public function export(Request $request): StreamedResponse
{
    $month = $request->integer('month');
    $year  = $request->integer('year');

    // Filter data berdasarkan bulan/tahun (opsional)
    $query = Parkir::query();
    if ($year)  $query->where('tahun', $year);
    if ($month) $query->where('bulan', $month);

    $parkirs = $query->orderBy('tanggal')->get();

    // Nama file
    $fileName = 'data_parkir_' . ($month ?: 'all') . '_' . ($year ?: 'all') . '.csv';

    // Streaming response CSV (bisa dibuka di Excel)
    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => "attachment; filename=\"$fileName\"",
    ];

    $callback = function () use ($parkirs) {
        $file = fopen('php://output', 'w');
        // Header kolom
        fputcsv($file, [
            'Tanggal', 'Shift', 'Pendapatan R2', 'Pendapatan R4',
            'Jumlah R2', 'Jumlah R4', 'Total', 'Bulan', 'Tahun'
        ]);

        foreach ($parkirs as $p) {
            fputcsv($file, [
                $p->tanggal,
                $p->shift,
                $p->pendapatan_r2,
                $p->pendapatan_r4,
                $p->jumlah_r2,
                $p->jumlah_r4,
                $p->total,
                $p->bulan,
                $p->tahun,
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

public function totals(Request $request)
{
    $month = $request->integer('month');
    $year  = $request->integer('year');

    $query = Parkir::query();
    if ($year)  $query->where('tahun', $year);
    if ($month) $query->where('bulan', $month);

    $data = $query->selectRaw('
        SUM(pendapatan_r2) as total_r2,
        SUM(pendapatan_r4) as total_r4,
        SUM(total) as total_semua
    ')->first();

    return response()->json([
        'total_r2'     => (int) ($data->total_r2 ?? 0),
        'total_r4'     => (int) ($data->total_r4 ?? 0),
        'total_semua'  => (int) ($data->total_semua ?? 0),
        'filter_bulan' => $month,
        'filter_tahun' => $year,
    ]);
}
}
