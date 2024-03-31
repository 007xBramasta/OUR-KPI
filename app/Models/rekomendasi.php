<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekomendasi extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'rekomendasi';
    protected $primaryKey = 'rekomendasi_id';
    public $timestamps = false;
}
