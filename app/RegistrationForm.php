<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistrationForm extends Model
{
    protected $fillable = [
        'registration_date', 'status', 'unusual_point', 'unusual_detail', 'patient_id', 'schedule_id', 'injection_times', 'vaccine_id', 'recent_injection_date'
    ];
    public function patient () {
        return $this->belongsTo(Patient::class);
    }
    public function schedule () {
        return $this->belongsTo(Schedule::class);
    }
    public function vaccine () {
        return $this->belongsTo(Vaccine::class);
    }
}
