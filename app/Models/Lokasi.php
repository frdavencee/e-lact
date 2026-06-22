<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Lokasi extends Model
{
    protected $table = 'locations';
    protected $fillable = [
        'branch_id',
        'name',
        'code',
        'address',
        'status',
    ];

    protected function kodeLokasi(): Attribute
    {
        return Attribute::get(fn () => $this->code);
    }

    protected function namaLokasi(): Attribute
    {
        return Attribute::get(fn () => $this->name);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function commissioningTest(): HasOne
    {
        return $this->hasOne(CommissioningTest::class);
    }

    public function boqItems(): HasMany
    {
        return $this->hasMany(BoqItem::class, 'lokasi_id');
    }

    public function markingKabel(): HasMany
    {
        return $this->hasMany(MarkingKabel::class);
    }

    public function fotoLampiran(): HasMany
    {
        return $this->hasMany(FotoLampiran::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'location_id');
    }

    public function project(): HasOne
    {
        return $this->hasOne(Project::class, 'location_id');
    }

    public function opmRecords(): HasManyThrough
    {
        return $this->hasManyThrough(OpMRecord::class, Project::class, 'location_id', 'project_id', 'id', 'id');
    }

    public function otdrFiles(): HasManyThrough
    {
        return $this->hasManyThrough(OtdrFile::class, Project::class, 'location_id', 'project_id', 'id', 'id');
    }

    public function waspang(): HasOneThrough
    {
        return $this->hasOneThrough(
            Personel::class,
            Project::class,
            'location_id',
            'id',
            'id',
            'waspang_id'
        );
    }

    public function generateLogs(): HasMany
    {
        return $this->hasMany(GenerateLog::class, 'lokasi_id');
    }
}
