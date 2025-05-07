<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResepTable extends Migration
{
    public function up(): void
    {
        Schema::create('resep', function (Blueprint $table) {
            $table->bigIncrements('ID_Resep'); // Primary key
            $table->unsignedBigInteger('ID_Pengguna'); // Foreign key
            $table->string('Nama_Resep', 255);
            $table->bigInteger('Kalori');
            $table->text('Langkah_Langkah');
            $table->string('Image_Resep', 255);
        
            // Foreign key constraint
            $table->foreign('ID_Pengguna')->references('ID_Pengguna')->on('pengguna')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resep');
    }
}