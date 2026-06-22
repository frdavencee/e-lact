<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    protected $fillable = [
        'name',
        'code',
    ];

    public function locations(): HasMany
    {
        return $this->hasMany(Lokasi::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
