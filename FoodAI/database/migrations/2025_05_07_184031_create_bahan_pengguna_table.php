<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBahanPenggunaTable extends Migration
{
    public function up(): void
    {
        Schema::create('bahan_pengguna', function (Blueprint $table) {
            $table->bigIncrements('ID_Bahan'); // Primary key
            $table->unsignedBigInteger('ID_Pengguna'); // Foreign key
            $table->string('Nama_Bahan', 255);
            $table->enum('Kategori_Bahan', ['Vegetable', 'Fruit', 'Meat', 'Dairy']);
            $table->bigInteger('Jumlah_Bahan');
            $table->float('Satuan_Bahan', 8, 2);
            $table->enum('Tipe_Satuan', ['kg', 'g', 'liters']);
            $table->date('Tgl_Kadaluarsa');
            $table->enum('Tipe_Penyimpanan', ['Fridge', 'Freezer', 'Pantry']);
            $table->dateTime('Tgl_Pembuatan');

            // Foreign key constraint
            $table->foreign('ID_Pengguna')->references('ID_Pengguna')->on('pengguna')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bahan_pengguna');
    }
}