<?php

namespace App\Http\Controllers;

use App\Patient;
use App\RegistrationForm;
use App\Schedule;
use App\Vaccine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VaccinationRegistrationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $schedule = Schedule::find($id);
        // $userId = Auth::user()->id;
        $patient = Auth::guard('patient')->user();
        // $vaccines = Vaccine::all();
        // $histories = new VaccinationHistory();
        $histories = $patient->vaccinationHistories;
        $numberOfinjections = count($patient->vaccinationHistories);
        $theNextDose = "";
        if($numberOfinjections != 0) {
            //doi voi nguoi tiem dau tien
            $suggestTimes = $histories->sortByDesc('created_at')->first();
            $theLastVaccineInjection = $suggestTimes->vaccineLot->vaccine; 
            if ($patient->required_additional_dose == 1) {
                if ($numberOfinjections < $theLastVaccineInjection->basic_dose) {
                    $theNextDose = count($patient->vaccinationHistories) + 1;
                } else if ($numberOfinjections >= $theLastVaccineInjection->basic_dose + $theLastVaccineInjection->additional_dose) {
                    $theNextDose = count($patient->vaccinationHistories) - $theLastVaccineInjection->additional_dose  + 1;
                } else {
                    $theNextDose = "AD";
                }
            } else {
                $theNextDose = count($patient->vaccinationHistories) + 1;
            }
            // return $numberOfinjections;
            return view('register-vaccination', compact('schedule', 'patient', 'theLastVaccineInjection', 'suggestTimes' , 'theNextDose'));
           
            
        } else {
            $suggestTimes = 0;
            return view('register-vaccination', compact('schedule', 'patient', 'suggestTimes'));
        }
       
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        for($i = 1 ; $i <= 10; $i++) {
            $unusual_detail_array[] = $data["rdTienSuBenh$i"];
        }
        $unusual_point = 0;
        if(in_array(1, $unusual_detail_array) || in_array(3, $unusual_detail_array)){
            $unusual_point = 1;
        }
        RegistrationForm::create([
            'registration_date' => date("Y-m-d"),
            'status' => 0,
            'unusual_point' => $unusual_point,
            'unusual_detail' => implode(",", $unusual_detail_array),
            'patient_id' => $data['patient'],
            'schedule_id' => $data['schedule'],
            'injection_times' => $data['injection_times'],
            'vaccine_id' => $data['vaccine'],
            'recent_injection_date' => $data['recent_injection_date']
        ]);
        return redirect()->route('schedule')->with('status', "Đã gửi phiếu đăng ký tiêm chủng!");
        
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
        RegistrationForm::find($id)->update([
          "status" => -2
        ]);
        return redirect()->route('vaccination.registration.history')->with("status", "Đã hủy 1 phiếu đăng ký");
    }

}
