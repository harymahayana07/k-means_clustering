<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kmeans', function (Blueprint $table) {
            $table->id();
            $table->integer('iteration')->comment('Nomor iterasi');
            $table->json('centroids')->comment('Dinamis Centroid pada iterasi ini');
            $table->json('clusters')->comment('Dinamis Cluster data points pada iterasi ini');
            $table->json('differences')->nullable()->comment('Dinamis Perubahan centroid dibanding iterasi sebelumnya');
            $table->integer('cluster_count')->comment('Dinamis Jumlah cluster');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kmeans');
    }
};
