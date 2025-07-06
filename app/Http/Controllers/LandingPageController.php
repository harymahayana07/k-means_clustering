<?php

namespace App\Http\Controllers;

use App\Models\HasilKmeans;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class LandingPageController extends Controller
{
    /**
     * Tampilkan Landing Page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $pelanggan = HasilKmeans::query()
            ->select('pelanggan_id', 'cluster_id')
            ->orderBy('cluster_id', 'asc')
            ->with('cluster', 'pelanggan')
            ->limit(6)
            ->get();

        $produkTerlaris = Transaksi::query()
            ->select(
                'produk_id',
                DB::raw('COUNT(*) AS transaksi_produk_count'),
                DB::raw('SUM(jumlah)    AS total_qty')
            )
            ->groupBy('produk_id')
            ->orderByDesc('total_qty')
            ->with('produk')
            ->limit(6)
            ->get();

        return view('welcome', compact('pelanggan', 'produkTerlaris'));
    }
}
