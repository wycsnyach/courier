<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

   protected $guarded = [];

    //public $timestamps = false;

    // Relationships
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function parcelsFrom()
    {
        return $this->hasMany(Parcel::class, 'from_branch_id');
    }

    public function parcelsTo()
    {
        return $this->hasMany(Parcel::class, 'to_branch_id');
    }
}
