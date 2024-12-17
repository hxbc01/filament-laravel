<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pensiun;

class PensiunController extends Controller
{
    public function getPensiunData(Request $request)
    {
        $data = Pensiun::selectRaw('jenis, YEAR(tmt) as year, COUNT(*) as count')
            ->groupBy('jenis', 'year')
            ->get();

        $years = $data->pluck('year')->unique()->sort()->values()->toArray();
        $categories = $years;

        $series = [];
        $jenisList = $data->pluck('jenis')->unique()->values()->toArray();
        foreach ($jenisList as $jenis) {
            $series[$jenis] = [];
            foreach ($years as $year) {
                $count = $data->where('jenis', $jenis)->where('year', $year)->sum('count');
                $series[$jenis][] = $count;
            }
        }

        return response()->json([
            'categories' => $categories,
            'series' => $series, 
        ]);
    }
}
