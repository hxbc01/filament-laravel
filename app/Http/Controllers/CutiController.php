<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use Illuminate\Http\Request;

class CutiController extends Controller
{
    public function getCutiData(Request $request)
    {
        $cutiData = Cuti::selectRaw('YEAR(mulai_tanggal) as tahun, jenis_cuti, COUNT(*) as jumlah')
            ->groupBy('tahun', 'jenis_cuti')
            ->orderBy('tahun')
            ->get();

        $categories = $cutiData->pluck('tahun')->unique()->values()->all();
        $groupedData = $cutiData->groupBy('jenis_cuti');

        $data = [];
        foreach ($groupedData as $jenis => $values) {
            $data[$jenis] = $categories;
            foreach ($values as $item) {
                $index = array_search($item->tahun, $categories);
                $data[$jenis][$index] = $item->jumlah;
            }
        }

        return response()->json([
            'categories' => $categories,
            'data' => $data,
        ]);
    }

}
