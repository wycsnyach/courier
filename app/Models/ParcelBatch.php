<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParcelBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_number', 'dispatched_by', 'dispatched_at','is_delivered','delivered_at','recipient_collected_at'
    ];

    public function parcels()
    {
        return $this->belongsToMany(Parcel::class, 'batch_parcel');
    }

    protected $casts = [
    'dispatched_at' => 'datetime',
    'delivered_at' => 'datetime',
    'received_at_branch_at' => 'datetime',
    'recipient_collected_at' => 'datetime',
];


}
