<?php

namespace App\Filament\Resources\KMeansResource\Pages;

use App\Filament\Resources\KMeansResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mockery\Undefined;
use SebastianBergmann\Type\ObjectType;

class ListKMeans extends ListRecords
{
    protected static string $resource = KMeansResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getHeader(): ?View
    {
        $data['master'] = 'Kalkulasi K-Means Model';
        $data['judul'] = 'K-Means';
        return view('filament.custom.header-kmeans', compact('data'));
    }

    public $jumlah_cluster = '';

    public function calculateClustering()
    {
        // Validasi jumlah cluster
        $clusterCount = (int) $this->jumlah_cluster;
        if ($clusterCount <= 0) {
            Notification::make()
                ->title('Jumlah Cluster')
                ->body('Jumlah Cluster tidak valid. Pastikan Anda telah mengisi jumlah cluster dengan benar.')
                ->danger()
                ->send();
            return;
        }

        // Validasi data RFM
        $rfms = DB::table('rfms')->get(['pelanggan_id', 'recency', 'frequency', 'monetary']);
        if ($rfms->isEmpty()) {
            Notification::make()
                ->title('Clustering Gagal')
                ->body('Data RFM tidak ditemukan. Pastikan Anda telah melakukan analisis RFM terlebih dahulu.')
                ->danger()
                ->send();
            return;
        }

        // Ambil data points dan pelanggan_id dari RFM
        $dataPoints = $rfms->map(fn($item) => [$item->recency, $item->frequency, $item->monetary])->toArray();
        $pelangganIds = $rfms->pluck('pelanggan_id')->toArray();

        // Validasi jumlah cluster lebih kecil dari jumlah data points
        if ($clusterCount > count($dataPoints)) {
            Notification::make()
                ->title('Clustering Gagal')
                ->body('Jumlah cluster tidak boleh lebih besar dari jumlah data RFM.')
                ->danger()
                ->send();
            return;
        }

        // Inisialisasi centroid secara acak
        DB::table('kmeans')->truncate(); // Bersihkan data lama
        $randomIndices = array_rand($dataPoints, $clusterCount);
        $centroids = array_map(fn($index) => $dataPoints[$index], (array) $randomIndices);

        $maxIterations = 100; // Maksimum iterasi
        $clusters = [];
        $prevCentroids = null;

        for ($iteration = 1; $iteration <= $maxIterations; $iteration++) {
            // Reset clusters di setiap iterasi
            $clusters = array_fill(0, $clusterCount, []);

            // Assign setiap data point ke cluster terdekat
            foreach ($dataPoints as $index => $point) {
                $distances = array_map(fn($centroid) => $this->euclideanDistance($point, $centroid), $centroids);
                $closestCluster = array_search(min($distances), $distances);
                $clusters[$closestCluster][] = $index;
            }

            // Simpan centroid sebelumnya
            $prevCentroids = $centroids;

            // Hitung centroid baru berdasarkan rata-rata dari setiap cluster
            foreach ($clusters as $clusterIndex => $clusterPoints) {
                if (!empty($clusterPoints)) {
                    $centroids[$clusterIndex] = array_map(
                        fn(...$values) => array_sum($values) / count($values),
                        ...array_map(fn($index) => $dataPoints[$index], $clusterPoints)
                    );
                }
            }

            // Hitung perubahan (differences) centroid dibanding iterasi sebelumnya
            $differences = $this->calculateDifferences($prevCentroids, $centroids);

            // Simpan hasil iterasi ke tabel `kmeans`
            DB::table('kmeans')->insert([
                'iteration' => $iteration,
                'centroids' => json_encode($centroids),
                'clusters' => json_encode($clusters),
                'differences' => json_encode($differences),
                'cluster_count' => $clusterCount,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Hentikan iterasi jika centroid tidak berubah
            if (empty(array_filter($differences))) {
                break;
            }
        }

        // Simpan hasil akhir clustering ke tabel pelanggan_clusters
        DB::table('hasil_kmeans')->truncate(); // Bersihkan data lama
        $clusterAssignments = [];
        foreach ($clusters as $clusterId => $clusterPoints) {
            foreach ($clusterPoints as $pointIndex) {
                $clusterAssignments[] = [
                    'pelanggan_id' => $pelangganIds[$pointIndex],
                    'cluster_id' => $clusterId + 1, // Cluster dimulai dari 1
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        Log::info('INI CLUSTER PELANGGAN YANG AKAN DISAVE:'.json_encode($clusterAssignments,JSON_PRETTY_PRINT));

        $hasilKmeans = DB::table('hasil_kmeans')->insert($clusterAssignments);

        // Kirim notifikasi sukses
        if ($hasilKmeans) {
            Notification::make()
                ->title('Clustering Berhasil')
                ->body('Hasil clustering telah disimpan ke database.')
                ->success()
                ->send();
        }
    }

    /**
     * Menghitung jarak Euclidean antara dua titik.
     */
    private function euclideanDistance(array $point1, array $point2): float
    {
        return sqrt(array_sum(array_map(fn($p1, $p2) => ($p1 - $p2) ** 2, $point1, $point2)));
    }

    /**
     * Menghitung perubahan (differences) antara dua centroid.
     */
    private function calculateDifferences(?array $prevCentroids, array $newCentroids): array
    {
        if (is_null($prevCentroids)) {
            return array_fill(0, count($newCentroids), null);
        }

        return array_map(
            fn($prev, $new) => array_sum(array_map(fn($p, $n) => abs($p - $n), $prev, $new)),
            $prevCentroids,
            $newCentroids
        );
    }

}
