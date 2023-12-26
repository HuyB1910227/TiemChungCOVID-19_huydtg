<?php

namespace App\Http\Controllers;

use App\ImmunizationUnit;
use App\RegistrationForm;
use App\Schedule;
use Illuminate\Http\Request;

class AdminVaccinationRegistrationController extends Controller
{
    public function index(Request $request) {

        $regForms = RegistrationForm::all();
        $immunizationUnits = ImmunizationUnit::all();
        $schedules = Schedule::all();
        if ($request->filled('immunization_unit_id')) {
            $immunization_unit_id = $request->input('immunization_unit_id');
            $schedules= $schedules->where('immunization_unit_id', $immunization_unit_id);
        }
        $regForms = collect();
        if($request->filled('vaccination_date')) {
            $vaccinationDate = $request->input('vaccination_date');
            $schedules = $schedules->where('vaccination_date', $vaccinationDate);
        }
        foreach ($schedules as $schedule) {
            $registrationForms = $schedule->registrationForms;
            foreach ($registrationForms as $registrationForm) {
                $regForms->push($registrationForm);
            }
        }

        $filteredData = $regForms;
        if ($request->filled('status')) {
            $status = $request->input('status');
            $filteredData = $filteredData->where('status', $status);
        }
    
        if ($request->filled('registration_date')) {
            $registrationDate = $request->input('registration_date');
            $filteredData = $filteredData->where('registration_date', $registrationDate);
        }
    
        if ($request->filled('unusual_point')) {
            $unusualPoint = $request->input('unusual_point');
            $filteredData = $filteredData->where('unusual_point', $unusualPoint);
        }
        return view('admin.vaccination-registration.index', compact('filteredData', 'immunizationUnits'));
    }

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
        return view('admin.vaccination-registration.show', compact('reg', 'Y', 'U'));
    }
}
