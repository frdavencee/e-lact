<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OtdrFile extends Model
{
    protected $table = 'otdr_files';

    protected $fillable = [
        'project_id',
        'odp_name',
        'file_path',
        'original_name',
        'mime_type',
        'size',
    ];

    protected function path(): Attribute
    {
        return Attribute::get(fn () => $this->file_path);
    }

    protected function namaFile(): Attribute
    {
        return Attribute::get(fn () => $this->original_name);
    }

    protected function tipe(): Attribute
    {
        return Attribute::get(fn () => pathinfo($this->original_name, PATHINFO_EXTENSION));
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
