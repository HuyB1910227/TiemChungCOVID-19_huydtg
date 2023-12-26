<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\ImmunizationUnit;
use App\Schedule;
class EmployeeTimetableController extends Controller
{

    public function findImmunizationUnitId () {
        return Auth::user()->employee->immunization_unit_id;
    }
    public function findImmunizationUnit () {
        return ImmunizationUnit::find(Auth::user()->employee->immunization_unit_id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = [];
        $groups = Auth::user()->employee->groups;
        // $vaccineLots = $this->findImmunizationUnit()->lots;
        foreach ($groups as $group) {
            if($group->schedule->status == 1){
                $schedules[] = $group->schedule;
            }
            // foreach($forms as $form){
            //     $regForms[] = $form;
            // }
            // $forms[] = $schedule->registrationForms; 
        }
        if(empty($schedules)){
            $schedules = -1;
        }
        return view('employee.timetable.index', compact('schedules'));
    }

    public function findSchedule(Request $request)
    {
      $fieldValue = $request->input('fieldName');
      // perform some action with the field value
      return response()->json(['success' => true]);
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
        $employees = [];
        $schedule = Schedule::find($id);
        $groups = $schedule->groups;
        foreach($groups as $group) {
            $employees[] = $group->employee;
        }
        return view('employee.timetable.show', compact('schedule', 'employees'));
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
