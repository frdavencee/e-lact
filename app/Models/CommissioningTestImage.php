<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommissioningTestImage extends Model
{
    protected $table = 'commissioning_test_images';

    protected $fillable = [
        'commissioning_test_id',
        'file_path',
        'label',
        'urutan',
    ];

    public function commissioningTest(): BelongsTo
    {
        return $this->belongsTo(CommissioningTest::class, 'commissioning_test_id');
    }
}
