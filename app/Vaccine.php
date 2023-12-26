<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    protected $fillable = [
        'name', 'basic_injections_interval', 'type_id', 'basic_dose', 'additional_dose', 'additional_injections_interval',
    ];

    public function type () {
        return $this->belongsTo('App\Type');
    }

    public function lots () {
        return $this->hasMany(VaccineLot::class);
    }

    public function schedules () {
        return $this->hasMany(Schedule::class);
    }

    public function registrationForms () {
        return $this->hasMany(RegistrationForm::class);
    }

    public function boosterVaccines()
    {
        return $this->belongsToMany(Vaccine::class, 'booster_vaccines', 'vaccine_id', 'appropriate_vaccine_id');
    }
}
