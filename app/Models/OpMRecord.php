<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OpMRecord extends Model
{
    protected $table = 'opm_measurements';

    protected $fillable = [
        'project_id',
        'scan',
        'odp_name',
        'port_1',
        'port_2',
        'port_3',
        'port_4',
        'port_5',
        'port_6',
        'port_7',
        'port_8',
        'loss_value',
        'notes',
    ];

    protected function namaOdp(): Attribute
    {
        return Attribute::get(fn () => $this->odp_name);
    }

    protected function port(): Attribute
    {
        return Attribute::get(fn () => $this->port_1);
    }

    protected function nilaiDbm(): Attribute
    {
        return Attribute::get(fn () => $this->loss_value ?? $this->port_1);
    }

    protected function catatan(): Attribute
    {
        return Attribute::get(fn () => $this->notes);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
