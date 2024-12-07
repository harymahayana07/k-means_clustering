<?php

namespace App\Livewire;

use App\Models\Transaksi;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class TransaksiChart extends Component
{
    public $data = [];
    public $tahun;
    public $daftarTahun = [];

    public function mount()
    {
        // Ambil daftar tahun
        $this->daftarTahun = Transaksi::selectRaw('DISTINCT EXTRACT(YEAR FROM tanggal_transaksi) as tahun')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();

        // Set tahun default ke tahun terbaru
        $this->tahun = $this->daftarTahun[0] ?? now()->year;

        // Load data pertama kali
        $this->loadData();
    }

    public function updatedTahun()
    {
        // Panggil loadData saat tahun diperbarui
        $this->loadData();
    }

    public function loadData()
    {
        // Muat data transaksi berdasarkan tahun
        $this->data = Transaksi::selectRaw('EXTRACT(MONTH FROM tanggal_transaksi) as month, SUM(jumlah * harga) as total_harga')
            ->whereRaw('EXTRACT(YEAR FROM tanggal_transaksi) = ?', [$this->tahun])
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->mapWithKeys(function ($row) {
                $monthNames = [
                    1 => 'January',
                    2 => 'February',
                    3 => 'March',
                    4 => 'April',
                    5 => 'May',
                    6 => 'June',
                    7 => 'July',
                    8 => 'August',
                    9 => 'September',
                    10 => 'October',
                    11 => 'November',
                    12 => 'December',
                ];
                return [$monthNames[$row->month] => $row->total_harga];
            })
            ->toArray();

        Log::info('Data setelah loadData:', ['tahun' => $this->tahun, 'data' => $this->data]);
    }

    public function render()
    {
        return view('livewire.transaksi-chart', [
            'data' => $this->data,
            'daftarTahun' => $this->daftarTahun,
        ]);
    }
}