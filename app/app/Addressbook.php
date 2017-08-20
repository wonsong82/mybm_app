<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addressbook extends Model
{
    protected $fillable = [
        'line1', // Street address, P.O. box, company name, c/o
        'line2', // Apartment, suite, unit, building, floor, etc.
        'city',
        'state', // State/Province
        'zip', // Zip/PostalCode
        'country',
        'user_profile_id'
    ];

    public function profile()
    {
        return $this->belongsTo(UserProfile::class);
    }
}
