<?php

namespace App\Http\Controllers;

use App\ImmunizationUnit;
use Illuminate\Http\Request;
use App\Schedule;
use App\Vaccine;

class AdminScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $vaccines = Vaccine::all();
        $immunizationUnits = ImmunizationUnit::all();
        $schedules = Schedule::all();

        if ($request->filled('immunization_unit_id')) {
            $immunization_unit_id = $request->input('immunization_unit_id');
            $schedules = $schedules->where('immunization_unit_id', $immunization_unit_id);
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            $schedules = $schedules->where('status', $status);
        }

        if ($request->filled('vaccination_date')) {
            $vaccination_date = $request->input('vaccination_date');
            $schedules = $schedules->where('vaccination_date', $vaccination_date);
        }
    
        if ($request->filled('vaccine_id')) {
            $vaccine_id = $request->input('vaccine_id');
            $schedules = $schedules->where('vaccine_id', $vaccine_id);
        }
        return view('admin.vaccination-schedule.index', compact('schedules', 'vaccines', 'immunizationUnits'));
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
        return view('admin.vaccination-schedule.show', compact('schedule', 'employees'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirm(Request $request, $id)
    {
        Schedule::find($id)->update([
            'status' => 1
        ]);
        if($request->input('old_url')){
            return redirect($request->input('old_url'))->with("status",  "Đã xác nhận kế hoạch tiêm: $id");
        }
        // return redirect()->route('admin.schedule')->with('status', "Đã xác nhận kế hoạch tiêm: $id");

        return redirect()->back()->with('status', "Đã xác nhận kế hoạch tiêm: $id");
    }

    public function cancel(Request $request, $id)
    {
        Schedule::find($id)->update([
            'status' => -1
        ]);
        if($request->input('old_url')){
            return redirect($request->input('old_url'))->with("status",  "Đã từ chối kế hoạch tiêm: $id");
        }
        // return redirect()->route('admin.schedule')->with('status', "Đã từ chối kế hoạch tiêm: $id");

        return redirect()->back()->with('status', "Đã từ chối kế hoạch tiêm: $id");
    }

    
}
