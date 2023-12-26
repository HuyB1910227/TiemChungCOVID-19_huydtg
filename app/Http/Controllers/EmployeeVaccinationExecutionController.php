<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\ImmunizationUnit;
use App\RegistrationForm;
use App\VaccinationHistory;
use App\Vaccine;
use App\VaccineLot;

use function PHPUnit\Framework\isNull;

class EmployeeVaccinationExecutionController extends Controller
{
    public function findImmunizationUnitId () {
        return Auth::user()->employee->immunization_unit_id;
    }
    public function findImmunizationUnit () {
        return ImmunizationUnit::find(Auth::user()->employee->immunization_unit_id);
    }
    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index(Request $request)
    // {
    //     //!!!!!
    //     // $regForms = [];
    //     //!!!!
    //     $groups = Auth::user()->employee->groups;
    //     // $vaccineLots = $this->findImmunizationUnit()->lots->where('expired_date', '<', now());
    //     $vaccineLots = $this->findImmunizationUnit()->lots->filter(function ($vaccineLot) {
    //         // parse in database
    //         return !Carbon::parse($vaccineLot->expired_date)->isPast();
    //     });
    //     //Tim kiem nhan vien nam trong group nao -> tim kiem lich tiem cua group do -> tim kiem nhung phieu tiem thuoj lich tiem do
    //     //!!!!!!!
    //     // foreach ($groups as $group) {
    //     //     $forms = $group->schedule->registrationForms;
    //     //     foreach($forms as $form){
    //     //         $regForms[] = $form;
    //     //     }
    //     //     // $forms[] = $schedule->registrationForms; 
    //     // }
    //     //!!!!!!!
    //     $vaccines = Vaccine::all();
    //     $regForms = collect();
    //     if($request->filled('vaccine_id') || $request->filled('vaccination_date')){
    //         foreach ($groups as $group) {
    //             $schedules = $group->schedule;
    //             if($request->filled('vaccine_id')) {
    //                 $schedules = $schedules->where('vaccine_id', $request->filled('vaccine_id'));
    //             }
    //             if($request->filled('vaccination_date')) {
    //                 $schedules = $schedules->where('vaccination_date', $request->filled('vaccination_date'));
    //             }
    //             $forms = [];
    //             foreach ($schedules->get() as $schedule) {
    //                 $forms[] = $schedule->registrationForms;
    //             }
    //             foreach($forms as $form) {
    //                 $regForms->push($form);
    //             }
    //         }
    //     } else {

    //     }
        
    //     $filteredData = $regForms;
    //     //reg
    //     if ($request->filled('registration_date')) {
    //         $registrationDate = $request->input('registration_date');
    //         $filteredData = $filteredData->where('registration_date', $registrationDate);
    //     }
    //     //unu
    //     if ($request->filled('unusual_point')) {
    //         $unusualPoint = $request->input('unusual_point');
    //         $filteredData = $filteredData->where('unusual_point', $unusualPoint);
    //     }
    //     //reg hasOne sch
    //     // if ($request->filled('vaccine_id') || $request->filled('vaccination_date')) {
    //         // $vaccineID = $request->input('vaccine_id');
    //         // $vaccinationDate = $request->input('vaccination_date');
    //         // $filteredForms = $filteredData;
    //         // //none schedule => request reg forms
    //         // foreach($filteredForms as $filteredForm) {
    //         //     // $filteredForm->schedule->where('vaccine_id', $vaccineID);
    //         //         $filteredData[] = $filteredForm->with('schedule', function($query) {
    //         //             $query->where('vaccine_id', $vaccineID);
    //         //         }
    //         //     )->get();
    //         // }
    //         // if($request->filled('vaccination_date')){

    //         // }
    //         // $filteredData = $filteredData->schedule->filter()
    //     // }
    //     return view('employee.vaccination-execute.index', compact('vaccineLots', 'filteredData', 'vaccines'));
    //     // return $regForms;
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $groups = Auth::user()->employee->groups;
        $vaccineLots = $this->findImmunizationUnit()->lots->filter(function ($vaccineLot) {
            return !Carbon::parse($vaccineLot->expired_date)->isPast();
        });
        $vaccines = Vaccine::all();
        $regForms = collect();
        if ($request->filled('vaccine_id') || $request->filled('vaccination_date')) {
            foreach ($groups as $group) {
                $schedules = $group->schedule();
                if ($request->filled('vaccine_id')) {
                    $schedules = $schedules->where('vaccine_id', $request->input('vaccine_id'));
                }
                if ($request->filled('vaccination_date')) {
                    $schedules = $schedules->whereDate('vaccination_date', $request->input('vaccination_date'));
                }
                $regForms = $regForms->merge($schedules->get()->flatMap(function ($schedule) {
                    return $schedule->registrationForms;
                }));
            }
        } else {
            
            foreach ($groups as $group) {
                $schedules = $group->schedule();
                $regForms = $regForms->merge($schedules->get()->flatMap(function ($schedule) {
                    return $schedule->registrationForms;
                }));
            }
        }
        
        $filteredData = $regForms;

        if ($request->filled('registration_date')) {
            $registrationDate = $request->input('registration_date');
            $filteredData = $filteredData->where('registration_date', $registrationDate);
        }
  
        if ($request->filled('unusual_point')) {
            $unusualPoint = $request->input('unusual_point');
            $filteredData = $filteredData->where('unusual_point', $unusualPoint);
        }

        return view('employee.vaccination-execute.index', compact('vaccineLots', 'filteredData', 'vaccines'));
       
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $data = $request->all();
        $reg = RegistrationForm::find($id);
        $reg->update([
            'status' => 2,
        ]);
        VaccinationHistory::create(
            [
                'number_of_injection' => $reg->injection_times, 
                'schedule_id' => $reg->schedule_id, 
                'patient_id' => $reg->patient_id,
                'vaccine_lot_id' => $data['vaccine_lot_id'],
            ]
        );
        if(isset($data['required_additional_dose'])) {
            $reg->patient->update([
                'required_additional_dose' => $data['required_additional_dose'],
            ]);
        } else {
            $reg->patient->update([
                'required_additional_dose' => null,
            ]);
        }
        return redirect()->back()->with('status', "Đã xử lý thành công 1 phiếu tiêm");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reg = RegistrationForm::find($id);
        $unusuals = [
            'Tiền sử phản vệ từ độ 2 trở lên',
            'Tiền sử bị COVID-19 trong vòng 6 tháng',
            'Tiền sử tiêm vắc xin trong vòng 14 ngày qua',
            'Tiền sử suy giảm miễn dịch, ung thư giai đoạn cuối, cắt lách, xơ gan,...',
            'Đang dùng thuốc ức chế miễn dịch, corticoid liều cao',
            'Bệnh cấp tính',
            'Tiền sử bệnh mãn tính, đang tiến triễn',
            'Tiền sử bệnh mạn tính đã điều trị ổn',
            'Tiền sử rối loạn đông máu hoặc đang dùng thuốc chống đông máu',
            'Tiền sử dị dứng với các dị nguyên khác'
        ];
        $arrayUnusuals = explode(',' , $reg->unusual_detail);
        for($i = 0; $i < 10; $i++){
            if($arrayUnusuals[$i] == 1) {
                $Y[] = $unusuals[$i];
            }
            else if($arrayUnusuals[$i] == 3) {
                $U[] = $unusuals[$i];
            }
        }
        if(empty($Y)){
            $Y[] = 0;
        }
        if(empty($U)){
            $U[] = 0;
        }
        return view('employee.vaccination-execute.show', compact('reg', 'Y', 'U'));
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

    public function cancel($id)
    {
        RegistrationForm::find($id)->update([
            "status" => -2
        ]);
        return redirect()->back()->with("status","Đã hủy 1 phiếu đăng ký");
        // return "hi";
    }
}
