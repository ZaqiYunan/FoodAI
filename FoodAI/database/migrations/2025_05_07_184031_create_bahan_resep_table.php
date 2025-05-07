<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBahanResepTable extends Migration
{
    public function up(): void
    {
        Schema::create('bahan_resep', function (Blueprint $table) {
            $table->bigIncrements('ID_Bahan'); // Primary key
            $table->unsignedBigInteger('ID_Resep'); // Foreign key
            $table->string('Nama_Bahan', 255);
            $table->bigInteger('Jumlah_Bahan');
            $table->float('Satuan_Bahan', 8, 2);
            $table->enum('Tipe_Satuan', ['kg', 'g', 'liters']);
            $table->bigInteger('Kalori');
            $table->string('Image_Bahan', 255);

            // Foreign key constraint
            $table->foreign('ID_Resep')->references('ID_Resep')->on('resep')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bahan_resep');
    }
}