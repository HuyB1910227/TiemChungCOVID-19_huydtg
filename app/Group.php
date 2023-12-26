<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Group extends Model
{
    protected $fillable = [
        'employee_id', 'schedule_id'
    ];

    public function employee () {
        return $this->belongsTo(Employee::class);
    }
    public function schedule () {
        return $this->belongsTo(Schedule::class);
    }

}
