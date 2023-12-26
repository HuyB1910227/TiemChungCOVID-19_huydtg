<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Schedule;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patient =  Auth::guard('patient')->user();
        $numberOfinjections = count($patient->vaccinationHistories);
        $theLastVaccination = $patient->vaccinationHistories->last();
        $theLastReg = $patient->registrationForms->last();
        $schedules = Schedule::where('vaccination_date', '>=', date('Y-m-d'))->where('status', 'like', '1')->get();
        if (!isset($theLastVaccination)) {
            $filteredSchedules = $schedules;
            return view('vaccination-schedule', compact('filteredSchedules', 'theLastVaccination', 'theLastReg'));
        }
        $theLastVaccineInjection = $theLastVaccination->vaccineLot->vaccine;
        
        if ($patient->required_additional_dose == 1) {
            $theSuccessfulDose = $theLastVaccineInjection->basic_dose + $theLastVaccineInjection->additional_dose;
        } else {
            $theSuccessfulDose = $theLastVaccineInjection->basic_dose;
        }
        $filteredSchedules = [];
        if($numberOfinjections < $theSuccessfulDose) {
            $filteredSchedules = $schedules->where('vaccine_id', $theLastVaccineInjection->id);
        } else {
            $appropriateVaccineIds = [];
            $appropriateVaccines = $theLastVaccineInjection->boosterVaccines;
            foreach($appropriateVaccines as $appropriateVaccine) {
                $appropriateVaccineIds[] = $appropriateVaccine->id;
            }
            array_push($appropriateVaccineIds, $theLastVaccineInjection->id);
            $filteredSchedules = $schedules->whereIn('vaccine_id', $appropriateVaccineIds);

        }
        
        if ($patient->required_additional_dose == 1) {
            if ($numberOfinjections < $theLastVaccineInjection->basic_dose) {
                $theNextDateVaccination = strtotime($theLastVaccination->created_at. "+ " .$theLastVaccineInjection->basic_injections_interval." days");
            } else if ($numberOfinjections > $theLastVaccineInjection->basic_dose + $theLastVaccineInjection->additional_dose) {
                $theNextDateVaccination = strtotime($theLastVaccination->created_at. "+ 112 days");
            } else {
                $theNextDateVaccination = strtotime($theLastVaccination->created_at. "+" .$theLastVaccineInjection->additional_injections_interval." days");
            }
        } else {
            if ($numberOfinjections < $theLastVaccineInjection->basic_dose) {
                $theNextDateVaccination = strtotime($theLastVaccination->created_at. "+" .$theLastVaccineInjection->basic_injections_interval." days");
            } else {
                $theNextDateVaccination = strtotime($theLastVaccination->created_at. "+ 112 days");
            }
        }

        $filteredSchedules = $filteredSchedules->where('vaccination_date', '>=', date('Y-m-d',$theNextDateVaccination));
        return view('vaccination-schedule', compact('filteredSchedules', 'theLastVaccination', 'theNextDateVaccination', 'theLastReg'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
