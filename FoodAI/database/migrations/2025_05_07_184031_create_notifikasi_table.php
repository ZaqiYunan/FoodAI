<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifikasiTable extends Migration
{
    public function up(): void
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->bigIncrements('ID_Notifikasi'); // Primary key
            $table->unsignedBigInteger('ID_Pengguna'); // Foreign key
            $table->text('Isi_Notifikasi');
            $table->enum('Status_Notifikasi', ['Unread', 'Read']);
            $table->dateTime('Tgl_Pembuatan');

            // Foreign key constraint
            $table->foreign('ID_Pengguna')->references('ID_Pengguna')->on('pengguna')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
}