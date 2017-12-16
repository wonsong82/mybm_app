<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RetreatApplication extends Model
{
    protected $fillable = [
        'user_id',
        'term',
        'uniform_size',

        'price',

        'paid_amount',
        'paid_status',
        'is_paid',
        'paid_at',
        'payment_method',

        'group',
        'room',
        'note'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function scopeFilterByTerm($query, $term)
    {
        $query->where('term', $term);
    }


}


