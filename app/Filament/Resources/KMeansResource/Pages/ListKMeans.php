<?php

namespace App\Filament\Resources\KMeansResource\Pages;

use App\Filament\Resources\KMeansResource;
use App\Notifications\ClusterAssignmentNotification;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification as FacadesNotification;
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
        $clusterCount = (int) $this->jumlah_cluster;
        if ($clusterCount <= 0) {
            Notification::make()
                ->title('Jumlah Cluster')
                ->body('Jumlah Cluster tidak valid. Pastikan Anda telah mengisi jumlah cluster dengan benar.')
                ->danger()
                ->send();
            return;
        }

        $rfms = DB::table('rfms')->get(['pelanggan_id', 'recency', 'frequency', 'monetary']);
        if ($rfms->isEmpty()) {
            Notification::make()
                ->title('Clustering Gagal')
                ->body('Data RFM tidak ditemukan. Pastikan Anda telah melakukan analisis RFM terlebih dahulu.')
                ->danger()
                ->send();
            return;
        }

        $dataPoints = $rfms->map(fn($item) => [$item->recency, $item->frequency, $item->monetary])->toArray();
        $pelangganIds = $rfms->pluck('pelanggan_id')->toArray();

        if ($clusterCount > count($dataPoints)) {
            Notification::make()
                ->title('Clustering Gagal')
                ->body('Jumlah cluster tidak boleh lebih besar dari jumlah data RFM.')
                ->danger()
                ->send();
            return;
        }

        DB::table('kmeans')->truncate();
        $randomIndices = array_rand($dataPoints, $clusterCount);
        $centroids = array_map(fn($index) => $dataPoints[$index], (array) $randomIndices);

        $maxIterations = 100;
        $clusters = [];
        $prevCentroids = null;

        for ($iteration = 1; $iteration <= $maxIterations; $iteration++) {
            $clusters = array_fill(0, $clusterCount, []);

            foreach ($dataPoints as $index => $point) {
                $distances = array_map(fn($centroid) => $this->euclideanDistance($point, $centroid), $centroids);
                $closestCluster = array_search(min($distances), $distances);
                $clusters[$closestCluster][] = $index;
            }

            $prevCentroids = $centroids;

            foreach ($clusters as $clusterIndex => $clusterPoints) {
                if (!empty($clusterPoints)) {
                    $centroids[$clusterIndex] = array_map(
                        fn(...$values) => array_sum($values) / count($values),
                        ...array_map(fn($index) => $dataPoints[$index], $clusterPoints)
                    );
                }
            }

            $differences = $this->calculateDifferences($prevCentroids, $centroids);

            DB::table('kmeans')->insert([
                'iteration' => $iteration,
                'centroids' => json_encode($centroids),
                'clusters' => json_encode($clusters),
                'differences' => json_encode($differences),
                'cluster_count' => $clusterCount,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if (empty(array_filter($differences))) {
                break;
            }
        }

        DB::table('hasil_kmeans')->truncate();
        $clusterAssignments = [];
        foreach ($clusters as $clusterId => $clusterPoints) {
            foreach ($clusterPoints as $pointIndex) {
                $clusterAssignments[] = [
                    'pelanggan_id' => $pelangganIds[$pointIndex],
                    'cluster_id' => $clusterId + 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        $hasilKmeans = DB::table('hasil_kmeans')->insert($clusterAssignments);

        if ($hasilKmeans) {
            $pelangganIdsWithEmail = DB::table('pelanggans')
            ->whereIn('id', collect($clusterAssignments)->pluck('pelanggan_id'))
            ->whereNotNull('email_pelanggan')
            ->where('email_pelanggan', '!=', '')
                ->get(['id', 'email_pelanggan', 'nama_pelanggan']);

            $emailMap = $pelangganIdsWithEmail->mapWithKeys(function ($item) {
                return [$item->id => ['email' => $item->email_pelanggan, 'name' => $item->nama_pelanggan]];
            });

            foreach ($clusterAssignments as $assignment) {
                if (isset($emailMap[$assignment['pelanggan_id']])) {
                    $email = $emailMap[$assignment['pelanggan_id']]['email'];
                    $name = $emailMap[$assignment['pelanggan_id']]['name'];
                    try {
                        FacadesNotification::route('mail', $email)
                        ->notify(new ClusterAssignmentNotification($assignment['cluster_id'], $name));
                    } catch (\Exception $e) {
                        Log::error("Error sending notification to {$email}: " . $e->getMessage());
                    }
                }
            }
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
