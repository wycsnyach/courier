<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParcelTrack extends Model
{
    use HasFactory;

    protected $fillable = [
        'parcel_id',
        'status',
    ];

    //public $timestamps = false;

    // Relationship
    public function parcel()
    {
        return $this->belongsTo(Parcel::class);
    }
}
