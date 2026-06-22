<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MarkingKabel extends Model
{
    protected $table = 'marking_kabel';
    protected $fillable = [
        'lokasi_id',
        'jenis_kabel',
        'panjang_meter',
    ];

    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class);
    }
}
