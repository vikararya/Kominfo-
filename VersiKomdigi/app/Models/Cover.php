<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class Cover extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model ini.
     *
     * @var string
     */
    protected $table = 'covers'; // Pastikan ini sesuai dengan nama tabel di database Anda.

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'image',
        'name',
        'logo',
        'dokumentasi_id',
        'versi_id',
        'kategori_id',
        'status',
        'author',
        'edited',
        'versi',
        'content',
    ];

    public function dokumentasis()
    {
        return $this->hasMany(Dokumentasi::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function versis()
    {
        return $this->hasMany(Versi::class);
    }

    public function subjudulList()
    {
        return $this->hasMany(Doksub::class);
    }

    // Dokumentasi.php
    public function scopeByVersi($query, $versiId)
    {
        return $query->where('versi_id', $versiId);
    }


}
