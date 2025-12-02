<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StockReport;
use Illuminate\Http\Request;

class StockReportController extends Controller
{
    /**
     * Menampilkan data laporan stok dari database view.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Mengambil semua data dari view v_final_stok_report
        $data = StockReport::all();

        // Mengembalikan data dalam format JSON agar bisa dibaca oleh Bootstrap Table
        return response()->json($data);
    }
}