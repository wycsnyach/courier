<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_number',
        'sender_name',
        'sender_address',
        'sender_contact',
        'recipient_name',
        'recipient_address',
        'recipient_contact',
        'type',
        'from_branch_id',
        'to_branch_id',
        'weight',
        'height',
        'width',
        'length',
        'price',
        'status',
    ];

    //public $timestamps = false;

    // Relationships
    public function fromBranch()
    {
        return $this->belongsTo(Branch::class, 'from_branch_id');
    }

    public function toBranch()
    {
        return $this->belongsTo(Branch::class, 'to_branch_id');
    }

    public function tracks()
    {
        return $this->hasMany(ParcelTrack::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getStatusBadgeAttribute()
    {
        $statuses = [
            0 => ['text' => 'Pending', 'class' => 'warning'],
            1 => ['text' => 'In Transit', 'class' => 'primary'],
            2 => ['text' => 'Delivered', 'class' => 'success'],
            3 => ['text' => 'Returned', 'class' => 'danger'],
        ];

        $status = $statuses[$this->status] ?? ['text' => 'Unknown', 'class' => 'default'];
        
        return '<span class="label label-' . $status['class'] . '">' . $status['text'] . '</span>';
    }
}
