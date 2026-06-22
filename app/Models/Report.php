<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    protected $fillable = [
        'project_id',
        'user_id',
        'title',
        'type',
        'description',
        'report_date',
        'location',
        'pd_staff',
        'findings',
        'recommendations',
        'action_plan',
        'generated_at',
    ];

    protected $casts = [
        'report_date' => 'date',
        'generated_at' => 'datetime',
    ];

    protected function reportDateFormatted(): Attribute
    {
        return Attribute::get(fn () => $this->report_date ? $this->report_date->format('d F Y') : '-');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
