<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'company_name', 'email', 'phone', 'street_address', 'city', 'country', 'logo'
    ];
}
