<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    protected $fillable = [
        'payment_id',
        'amount_paid',
        'payment_mode_id',
        'transaction_reference',
        'payment_date',
        'notes'
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'amount_paid' => 'decimal:2',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function paymentMode()
    {
        return $this->belongsTo(Paymentmode::class, 'payment_mode_id');
    }
}