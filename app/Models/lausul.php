<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\Json;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Klausul extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'klausuls';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function klausul_items(): HasMany
    {
        return $this->hasMany(KlausulItem::class, 'klausul_id');
    }
}