<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'parcel_id',
        'paymentmode_id',
        'amount',
        'transaction_reference',
        'payment_date',
    ];

    protected $casts = [
        'payment_date' => 'datetime', // This ensures it's a Carbon instance
        'amount' => 'decimal:2',
    ];

    // Relationships
    public function parcel()
    {
        return $this->belongsTo(Parcel::class);
    }

    public function paymentMode()
    {
        return $this->belongsTo(Paymentmode::class, 'paymentmode_id');
    }

    public function histories()
    {
        return $this->hasMany(PaymentHistory::class);
    }
}
