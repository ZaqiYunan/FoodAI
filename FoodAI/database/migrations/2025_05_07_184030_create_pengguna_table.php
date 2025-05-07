<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenggunaTable extends Migration
{
    public function up(): void
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->bigIncrements('ID_Pengguna'); // Primary key
            $table->string('Nama_Pengguna', 255);
            $table->string('Email_Pengguna', 255)->unique();
            $table->string('Password_Pengguna', 255);
            $table->enum('Role_Pengguna', ['Admin', 'User']);
            $table->dateTime('Tgl_Pembuatan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
}