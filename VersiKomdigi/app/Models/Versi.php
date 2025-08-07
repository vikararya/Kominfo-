<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class Versi extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model ini.
     *
     * @var string
     */
    protected $table = 'versis'; // Pastikan ini sesuai dengan nama tabel di database Anda.

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'versi',
        'cover_id',
        'dokumentasi_id',
        'created_ad',
    ];

    public function cover()
    {
        return $this->belongsTo(Cover::class);
    }

    public function dokumentasi()
    {
        return $this->belongsTo(Dokumentasi::class);
    }

    public function subjudulList(): HasManyThrough
    {
        return $this->hasManyThrough(Doksub::class, Dokumentasi::class, 'versi_id', 'dokumentasi_id');
    }

}
