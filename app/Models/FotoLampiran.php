<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FotoLampiran extends Model
{
    protected $table = 'foto_lampiran';
    protected $fillable = [
        'lokasi_id',
        'kategori',
        'label',
        'file_path',
        'urutan',
    ];

    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class);
    }
}
