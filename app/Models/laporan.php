<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Laporan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'laporan';
    protected $primaryKey = 'laporan_id';
    protected $guarded = [
        'laporan_id'
    ];
    
    public $timestamps = true;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }

    public function rekomendasi(): HasMany
    {
        return $this->hasMany(Rekomendasi::class, 'laporan_id' , 'laporan_id' );
    }

    public function penilaian(): HasMany
    {
        return $this->hasMany(Penilaian::class, 'laporan_id');
    }

    public function department()
    {
        return $this->user->belongsTo(Departement::class,'departements_id','departements_id' );
    }
}
