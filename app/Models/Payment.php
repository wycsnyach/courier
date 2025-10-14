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

    // Relationships
    public function parcel()
    {
        return $this->belongsTo(Parcel::class);
    }

    public function paymentMode()
    {
        return $this->belongsTo(PaymentMode::class, 'paymentmode_id');
    }
}
