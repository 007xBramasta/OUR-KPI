<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
