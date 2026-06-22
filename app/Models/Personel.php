<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Personel extends Model
{
    protected $table = 'waspangs';

    protected $fillable = [
        'name',
        'nik',
        'position',
        'phone',
    ];

    protected function nama(): Attribute
    {
        return Attribute::get(fn () => $this->name);
    }

    protected function jabatan(): Attribute
    {
        return Attribute::get(fn () => $this->position ?? 'WASPANG');
    }

    public function commissioningTests(): HasMany
    {
        return $this->hasMany(CommissioningTest::class, 'personel_id');
    }
}
