<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvidenceImage extends Model
{
    protected $table = 'project_evidence';

    protected $fillable = [
        'project_id',
        'uploaded_by',
        'category',
        'file_path',
        'original_name',
        'mime_type',
        'size',
        'sort_order',
    ];

    protected function path(): Attribute
    {
        return Attribute::get(fn () => $this->file_path);
    }

    protected function namaFile(): Attribute
    {
        return Attribute::get(fn () => $this->original_name);
    }

    protected function label(): Attribute
    {
        return Attribute::get(fn () => $this->original_name);
    }

    protected function kategori(): Attribute
    {
        return Attribute::get(fn () => $this->category);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
