<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'name',
        'contract_number',
        'purchase_order_number',
        'branch_id',
        'location_id',
        'implementer',
        'status',
        'notes',
        'user_id',
        'waspang_id',
    ];

    protected $casts = [
        'sp_date' => 'date',
        'commissioning_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function boqItems(): HasMany
    {
        return $this->hasMany(BoqItem::class);
    }

    public function evidenceImages(): HasMany
    {
        return $this->hasMany(EvidenceImage::class);
    }

    public function opmRecords(): HasMany
    {
        return $this->hasMany(OpMRecord::class);
    }

    public function otdrFiles(): HasMany
    {
        return $this->hasMany(OtdrFile::class);
    }

    public function waspangRelation(): BelongsTo
    {
        return $this->belongsTo(Personel::class, 'waspang_id');
    }

    public function branchRelation(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function approval()
    {
        return $this->morphOne(Approval::class, 'approvable');
    }

    public function mancoreItems(): HasMany
    {
        return $this->hasMany(MancoreItem::class, 'project_id');
    }
}
