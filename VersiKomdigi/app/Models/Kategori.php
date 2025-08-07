<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class Kategori extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model ini.
     *
     * @var string
     */
    protected $table = 'kategoris'; // Pastikan ini sesuai dengan nama tabel di database Anda.

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'cover_id',
        'deskripsi',
        'icon',
        'created_at',
    ];

    public function covers()
    {
        return $this->hasMany(Cover::class);
    }
}
