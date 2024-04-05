<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Laporan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'laporan';
    protected $primaryKey = 'laporan_id';
    protected $guarded = [
        'laporan_id'
    ];

    public $timestamps = true;

    protected $casts = [
        'created_at' => 'datetime:U',
        'updated_at' => 'datetime:U',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function rekomendasi(): HasMany
    {
        return $this->hasMany(Rekomendasi::class, 'laporan_id', 'laporan_id');
    }

    public function penilaians():HasMany
    {
        return $this->hasMany(Penilaian::class, 'laporan_id', 'id');
    }

    public function klausul_items(): HasManyThrough
    {
        return $this->hasManyThrough(KlausulItem::class, Penilaian::class, 'klausul_item_id', 'id', 'laporan_id');
    }
}
