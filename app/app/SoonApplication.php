<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoonApplication extends Model
{
    protected $fillable = [
        'user_id',
        'term',
        'status',
        'need_ride',
        'can_provide_ride',
        'can_provide_place',
        'age_preference'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeTerm($query, $term)
    {
        return $query->where('term', $term);
    }



}
