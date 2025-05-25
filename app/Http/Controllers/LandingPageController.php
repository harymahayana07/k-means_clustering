<?php

namespace App\Http\Controllers;

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
        $pelanggan = Transaksi::query()
            ->select('pelanggan_id', DB::raw('COUNT(*) AS total_transaksi'))
            ->groupBy('pelanggan_id')
            ->orderByDesc('total_transaksi')
            ->with('pelanggan')
            ->limit(12)
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
