<?php

namespace Database\Seeders;

use App\Models\Cluster;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeder untuk user
        $users = [
            [
                'name' => 'superadmin',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('superadmin'),
            ],
            [
                'name' => 'arikmahayana',
                'email' => 'arikmahayana@gmail.com',
                'password' => Hash::make('arikmahayana'),
            ],
            [
                'name' => 'Lalu Doni Setiawan',
                'email' => 'laludonisetiawan@gmail.com',
                'password' => Hash::make('laludonisetiawan'),
            ],
        ];

        foreach ($users as $user) {
            User::factory()->create($user);
        }

        // Seeder untuk cluster
        $clusters = [
            [
                'nama' => 'High Value',
                'deskripsi' => 'Pelanggan dengan nilai K-Means tinggi. Biasanya pelanggan setia dengan pembelian yang sering dan bernilai besar.',
            ],
            [
                'nama' => 'Medium Value',
                'deskripsi' => 'Pelanggan dengan nilai K-Means menengah. Pelanggan dengan aktivitas belanja yang cukup.',
            ],
            [
                'nama' => 'Low Value',
                'deskripsi' => 'Pelanggan dengan nilai K-Means rendah. Pelanggan baru atau tidak aktif.',
            ],
        ];

        foreach ($clusters as $cluster) {
            Cluster::factory()->create($cluster);
        }
    }
}
