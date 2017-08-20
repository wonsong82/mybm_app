<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'gender',
        'birthday',
        'avatar'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function phone()
    {
        return $this->hasOne(Phonebook::class);
    }

    public function address()
    {
        return $this->hasOne(Addressbook::class);
    }
}
