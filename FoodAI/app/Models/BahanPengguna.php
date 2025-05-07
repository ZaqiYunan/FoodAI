<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanPengguna extends Model
{
    use HasFactory;

    protected $table = 'Bahan_Pengguna';
    protected $primaryKey = 'ID_Bahan';
    public $timestamps = false;

    protected $fillable = [
        'ID_Pengguna',
        'Nama_Bahan',
        'Kategori_Bahan',
        'Jumlah_Bahan',
        'Tipe_Penyimpanan',
        'Tanggal_Produksi',
        'Tanggal_Kadaluarsa',
        'Tgl_Pembuatan',
    ];
}