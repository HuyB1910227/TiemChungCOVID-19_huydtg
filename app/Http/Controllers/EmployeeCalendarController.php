<?php

namespace App\Http\Controllers;

use App\Vaccine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class EmployeeCalendarController extends Controller
{
    public function index () {
        return view('employee.timetable.full-calendar');
    }
    public function getEvents(Request $request)
    {
        $schedules = [];
        $groups = Auth::user()->employee->groups;
        foreach ($groups as $group) {
            $schedules[] = $group->schedule;
        }
        // if($request->ajax()) {
        //     $data = $schedules;
        //     return response()->json($data);
        // }
        // return view('employee.timetable.full-calendar', compact('schedules'));
        $events = [];
        foreach ($schedules as $schedule) {
            $events[] = [
                "id" => $schedule["id"],
                "title" => Vaccine::find($schedule['vaccine_id'])->name,
                'start' => $schedule['vaccination_date'].' '.$schedule['start_time'],
                'end' => $schedule['vaccination_date'].' '.$schedule['end_time'],
            ];
        }
        
        return response()->json($events);
    }
}
