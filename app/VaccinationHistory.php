<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class VaccinationHistory extends Model
{
    protected $fillable = [
        'status_after', 'number_of_injection', 'schedule_id', 'patient_id', 'vaccine_lot_id'
    ];

    public function vaccineLot () {
        return $this->belongsTo(VaccineLot::class);
    }
    public function schedule () {
        return $this->belongsTo(Schedule::class);
    }
    public function patient () {
        return $this->belongsTo(Patient::class);
    }
}
