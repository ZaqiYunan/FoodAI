<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'Notifikasi';
    protected $primaryKey = 'ID_Notifikasi';
    public $timestamps = false;

    protected $fillable = [
        'ID_Pengguna',
        'Isi_Notifikasi',
        'Status_Notifikasi',
        'Tgl_Pembuatan',
    ];

    // Relationship with Pengguna (User)
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'ID_Pengguna', 'ID_Pengguna');
    }
}