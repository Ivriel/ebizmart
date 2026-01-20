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
        Schema::create('stuffs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('nama_barang');
            $table->integer('harga_barang');
            $table->text('keterangan_barang');
            $table->integer('stok_barang');
            $table->date('exp_barang');
            $table->enum('status_ketersediaan', ['Tersedia', 'Habis', 'Pre_Order']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stuffs');
    }
};
