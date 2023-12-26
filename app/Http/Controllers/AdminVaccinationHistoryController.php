<?php

namespace App\Http\Controllers;

use App\ImmunizationUnit;
use App\VaccinationHistory;
use Illuminate\Http\Request;

use App\RegistrationForm;
use App\Schedule;
use App\Vaccine;
use App\VaccineLot;

class AdminVaccinationHistoryController extends Controller
{
    public function index(Request $request) {
        $vaccinationHistories = VaccinationHistory::all();
        $vacHistories = VaccinationHistory::all();
        $vaccines = Vaccine::all();
        $immunizationUnits = ImmunizationUnit::all();
        // $schedules = Schedule::all();
        if ($request->filled('immunization_unit_id')) {

            $immunization_unit_id = $request->input('immunization_unit_id');
            $schedules = Schedule::where('immunization_unit_id', $immunization_unit_id)->get();
            $scheduleIds = [];
            if (!empty($schedules)) {
                foreach($schedules as $schedule) {
                    $scheduleIds[] =  $schedule->id;
                }
                $vacHistories = $vacHistories->whereIn('schedule_id', $scheduleIds);
                // return $vacHistories;
            }
            
            
        }
        if($request->filled('vaccine_id')) {
            $vaccineID = $request->input('vaccine_id');
            $lots= VaccineLot::where('vaccine_id', $vaccineID)->get();
            $lotIds = [];
            if (!empty($lots)) {
                foreach($lots as $lot) {
                    $lotIds[] =  $lot->id;
                }
                $vacHistories = $vacHistories->whereIn('vaccine_lot_id', $lotIds);
            }
        }
            
            if ($request->filled('created_at')) {
                $value = $request->input('created_at');
                $vacHistories = $vacHistories->whereBetween('created_at', [date("Y-m-d 00:00:00", strtotime($value)), date("Y-m-d 23:59:59", strtotime($value))]);
            }
        return view('admin.vaccination-history.index', compact('vacHistories', 'vaccines', 'immunizationUnits', 'vaccinationHistories'));
    }

    
}
