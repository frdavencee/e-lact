<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoqItem extends Model
{
    protected $fillable = [
        'project_id',
        'lokasi_id',
        'item_code',
        'name',
        'volume',
        'unit',
        'price',
        'total',
        'notes',
        'volume_drm',
        'volume_aktual',
        'volume_tambah',
        'volume_kurang',
    ];

    protected function kodeItem(): Attribute
    {
        return Attribute::get(fn () => $this->item_code);
    }

    protected function namaItem(): Attribute
    {
        return Attribute::get(fn () => $this->name);
    }

    protected function satuan(): Attribute
    {
        return Attribute::get(fn () => $this->unit);
    }

    protected function keterangan(): Attribute
    {
        return Attribute::get(fn () => $this->notes);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }
}
