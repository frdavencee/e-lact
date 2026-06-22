<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CommissioningTest extends Model
{
    protected $table = 'commissioning_tests';

    protected $fillable = [
        'lokasi_id',
        'personel_id',
        'tanggal',
        'kota_ttd',
        'status_pekerjaan',
        'status_hasil',
        'status_kelayakan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }

    public function personel(): BelongsTo
    {
        return $this->belongsTo(Personel::class, 'personel_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(CommissioningTestImage::class, 'commissioning_test_id')->orderBy('urutan');
    }
}
