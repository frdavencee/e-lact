<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MancoreItem extends Model
{
    protected $table = 'mancore_items';

    protected $fillable = [
        'project_id',
        'core_from',
        'warna',
        'core_to',
        'description',
        'file_path',
        'original_name',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
