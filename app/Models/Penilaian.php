<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Penilaian extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'penilaian';
    protected $primaryKey = 'penilaian_id';
    protected $guarded = [
        'penilaian_id'
    ];
    public $timestamps = false;

    public function klausul(): HasOne{
        return $this->hasOne(Klausul::class, 'klausul_id', 'klausul_id');
    }
}
