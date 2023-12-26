<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VaccineLot extends Model
{
    protected $fillable = [
        'id', 'lot_code', 'quantity', 'manufacturing_date', 'transaction_date', 'expired_date', 'vaccine_id', 'immunization_unit_id'
    ];

    public function vaccine () {
        return $this->belongsTo(Vaccine::class);
    }
    public function immunizationUnit () {
        return $this->belongsTo(ImmunizationUnit::class);
    }
    public function vaccinationHistories () {
        return $this->hasMany(VaccinationHistory::class);
    }
}
