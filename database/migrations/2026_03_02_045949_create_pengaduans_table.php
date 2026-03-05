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
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('pelapor');
            $table->string('kelas');
            $table->string('sarana');
            $table->string('lokasi');
            $table->text('detail')->nullable();
            $table->date('tanggal');
            $table->string('foto')->nullable();
            $table->enum('status', ['Menunggu', 'Diperbaiki', 'Selesai'])->default('Menunggu');
            $table->timestamps();    

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};
