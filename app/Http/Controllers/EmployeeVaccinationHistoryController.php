<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ImmunizationUnit;
use App\VaccinationHistory;
use App\Vaccine;

class EmployeeVaccinationHistoryController extends Controller
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
    public function index(Request $request)
    {
        
        $vaccinationHistories = VaccinationHistory::all();
        $vaccines = Vaccine::all();
        $vacHistories = collect();
        $vaccinationHistories = [];
        $schedules = $this->findImmunizationUnit()->schedules;
        if($request->filled('vaccine_id')) {
            $vaccineID = $request->input('vaccine_id');
            $array = $schedules;
            $schedules = [];
            foreach($array as $value) {
                if($value->vaccine_id == $vaccineID) {
                    $schedules[] = $value;
                }
            }

        }
            foreach ($schedules as $schedule) {
                $vaccinationHistories = $schedule->vaccinationHistories;
                foreach ($vaccinationHistories as $vaccinationHistory) {
                    $vacHistories->push($vaccinationHistory);
                }
            }
            // if ($request->filled('number_of_injection')) {
            //     $numberOfInjection = $request->input('number_of_injection');
            //     $vacHistories = $vacHistories->where('number_of_injection', $numberOfInjection);
            // }
            if ($request->filled('created_at')) {
                $value = $request->input('created_at');
                $vacHistories = $vacHistories->whereBetween('created_at', [date("Y-m-d 00:00:00", strtotime($value)), date("Y-m-d 23:59:59", strtotime($value))]);
            }

        return view('employee.vaccination-history.index', compact('vacHistories', 'vaccines', 'vaccinationHistories'));
        
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
        $data = $request->all();
        VaccinationHistory::find($id)->update([
            'status_after' => $data['status_after'] == '' ? 'Chưa cập nhật' : $data['status_after']
        ]);
        if(isset($data['required_additional_dose'])) {
            VaccinationHistory::find($id)->patient->update([
                'required_additional_dose' => $data['required_additional_dose'],
            ]);
        } else {
            VaccinationHistory::find($id)->patient->update([
                'required_additional_dose' => null,
            ]);
        }
        // return redirect()->route('employee.vaccination.history')->with('status', 'Đã cập nhật một trạng thái sau tiêm');
        return redirect()->back()->with('status', 'Đã cập nhật một trạng thái sau tiêm');
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
