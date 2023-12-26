<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'vaccination_date', 'start_time', 'end_time', 'status', 'vaccine_id', 'immunization_unit_id'
    ];

    public function vaccinationHistories () {
        return $this->hasMany(VaccinationHistory::class);
    }
    public function vaccine() {
        return $this->belongsTo(Vaccine::class);
    }
    public function immunizationUnit(){
        return $this->belongsTo(ImmunizationUnit::class);
    }
    
    public function registrationForms () {
        return $this->hasMany(RegistrationForm::class);
    }
    public function groups () {
        return $this->hasMany(Group::class);
    } 

}
