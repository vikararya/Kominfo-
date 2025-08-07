<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class Doksub extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model ini.
     *
     * @var string
     */
    protected $table = 'dokumsubs'; // Pastikan ini sesuai dengan nama tabel di database Anda.

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'subjudul',
        'dokumentasi_id',
        'status',
        'deskripsi',
        'created_at',
        'updated_at',
    ];


    public function dokumentasi()
    {
        return $this->belongsTo(Dokumentasi::class, 'dokumentasi_id');
    }

    public function versi()
    {
        return $this->hasOneThrough(Versi::class, Dokumentasi::class);
    }

}
