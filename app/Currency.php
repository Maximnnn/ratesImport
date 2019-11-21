<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = ['code'];

    public function rate(string $date) {
        return $this->hasOne(Rates::class)->where('date', $date);
    }

    public function rates()
    {
        return $this->hasMany(Rates::class);
    }
}
