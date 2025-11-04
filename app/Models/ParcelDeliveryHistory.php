<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParcelDeliveryHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'parcel_id',
        'user_id',
        'action',
        'remarks',
        'action_time',
    ];

    public function parcel()
    {
        return $this->belongsTo(Parcel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
