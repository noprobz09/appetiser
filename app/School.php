<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $table = 'schools';

    protected $fillable = [
        'name',
        'division_id'
    ];

    public function division() {

        return $this->belongsTo(Division::class);
    }

    public function passers() {

        return $this->hasMany(Passer::class);
    }

}
