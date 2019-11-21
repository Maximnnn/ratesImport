<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rates extends Model
{
    protected $fillable = ['currencyId', 'rate', 'date'];

    public $timestamps = false;

    public function currency()
    {
        return $this->hasOne(Currency::class, 'id', 'currencyId');
    }
}
