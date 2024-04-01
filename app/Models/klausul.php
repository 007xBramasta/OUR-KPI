<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klausul extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'klausul';
    protected $primaryKey = 'klausul_id';
    public $timestamps = false;


    protected $casts = [
        'item' => 'array'
    ];
}
