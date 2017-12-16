<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class RetreatApplication extends Model
{
    use CrudTrait;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    //protected $table = 'retreat_applications';
    //protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
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
    // protected $hidden = [];
     protected $dates = [
         'paid_at'
     ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeTerm($query, $term)
    {
        $query->where('term', $term);
    }


    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    public function getUsersNameAttribute()
    {
        return $this->user->name;
    }

    public function getTermNameAttribute()
    {
        switch($this->term){
            case '17_W':
                return '2017 겨울 수련회';
            case '18_S':
                return '2018 여름 수련회';
        }
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
