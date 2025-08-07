<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class Dokumentasi extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model ini.
     *
     * @var string
     */
    protected $table = 'dokumentasis'; // Pastikan ini sesuai dengan nama tabel di database Anda.

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'judul',
        'cover_id',
        'versi_id',
        'edited',
        'status',
        'order',
        'deskripsi',
        'created_at',
        'updated_at',
    ];

    public function cover()
    {
        return $this->belongsTo(Cover::class);
    }

    public function versis()
    {
        return $this->belongsTo(Versi::class, 'versi_id');
    }


    public function subjudulList()
    {
        return $this->hasMany(Doksub::class, 'dokumentasi_id');
    }
}
