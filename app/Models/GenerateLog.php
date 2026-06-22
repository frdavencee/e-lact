<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GenerateLog extends Model
{
    protected $table = 'generated_documents';
    protected $fillable = [
        'lokasi_id',
        'generated_by',
        'generated_at',
        'file_path',
        'versi',
    ];

    protected $casts = [
        'generated_at' => 'datetime',
    ];

    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class);
    }
}
