<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Departement extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'departements';
    protected $primaryKey = 'departements_id';


    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'departements_id', 'id');
    }

    public function rekomendasi(): HasManyThrough
    {
        return $this->hasManyThrough(Rekomendasi::class, Laporan::class, 'departements_id', 'laporan_id', 'rekomendasi_id');
    }

    public function laporans(): HasManyThrough
    {
        return $this->hasManyThrough(
            Laporan::class,
            User::class,
            'departements_id',
            'user_id',
            'departements_id',
            'id'
        );
    }

    public function klausul_items()
    {
        return $this->belongsToMany(
            KlausulItem::class,
            'departement_klausul_item',
            'departement_id',
            'klausul_item_id',
            'departements_id',
            'id'
        );
    }
}
