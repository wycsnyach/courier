<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchDeliveryHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'user_id',
        'action',
        'location',
        'action_time',
        'remarks',
        'signature_path',
    ];

    public function batch()
    {
        return $this->belongsTo(ParcelBatch::class, 'batch_id');
    }

    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
