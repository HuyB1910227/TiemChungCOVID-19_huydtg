<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImmunizationUnit extends Model
{
    protected $fillable = [
        'name', 'address', 'operating_license', 'hotline', 'status'
    ];


    public function employees () {
        return $this->hasMany(Employee::class);
    }
    public function lots () {
        return $this->hasMany(VaccineLot::class);
    }
    public function schedules () {
        return $this->hasMany(Schedule::class);
    }
}
