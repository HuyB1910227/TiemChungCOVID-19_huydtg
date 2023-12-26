<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoosterVaccine extends Model
{
    protected $fillable = [
        'vaccine_id', 'appropriate_vaccine_id'
    ];
}
