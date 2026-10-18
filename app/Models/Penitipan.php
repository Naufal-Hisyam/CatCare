<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penitipan extends Model
{
    protected $table = 'penitipan';

    protected $fillable = [
        'user_id',
        'cat_id',
        'layanan_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'catatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cat()
    {
        return $this->belongsTo(Cat::class, 'cat_id');
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }
}