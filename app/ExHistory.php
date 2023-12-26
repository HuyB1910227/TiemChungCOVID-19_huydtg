<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExHistory extends Model
{
    protected $fillable = [
        'number', 'ex_time', 'vaccine_id', 'immunization_unit_id'
    ];

    public function vaccineLot () {
        return $this->belongsTo(VaccineLot::class);
    }
    public function vaccinationHistories() {
        return $this->belongsTo(VaccinationHistory::class);
    }
}
