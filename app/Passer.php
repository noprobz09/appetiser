<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\School;

class Passer extends Model
{
    protected $table = 'passers';

    protected $fillable = [
        'firstname',
        'lastname',
        'school_id'
    ];

    public function school() {

        return $this->belongsTo(School::class);
    }

    
}
