<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{
    use HasFactory;

    protected $table = 'Pengguna';
    protected $primaryKey = 'ID_Pengguna';
    public $timestamps = false;

    protected $fillable = [
        'Nama_Pengguna',
        'Email_Pengguna',
        'Password_Pengguna',
        'Role_Pengguna',
        'Tgl_Pembuatan',
    ];

    protected $hidden = [
        'Password_Pengguna', // Ensure this is hidden for security
    ];

    public function getAuthPassword()
    {
        return $this->Password_Pengguna; // Specify the password column
    }
}