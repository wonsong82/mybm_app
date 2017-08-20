<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phonebook extends Model
{
    protected $fillable = [
        'country_code',
        'area_code', // Province/state/region
        'exchange', // prefix/switch
        'line_number',
        'extension_number',
        'user_profile_id'
    ];


    public function profile()
    {
        return $this->belongsTo(UserProfile::class);
    }
}
