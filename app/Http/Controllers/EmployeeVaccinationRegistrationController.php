<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\ImmunizationUnit;
use App\RegistrationForm;
use App\Jobs\SendConfirmRegistrationEmail;

class EmployeeVaccinationRegistrationController extends Controller
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
    // public function index(Request $request)
    // {
    //     $schedules = $this->findImmunizationUnit()->schedules;
    //     // $regForms = [RegistrationForm::class];
    //     // foreach($schedules as $schedule){
    //         // $regForms[] = $schedule->registrationForms;
    //         foreach ($schedules as $schedule) {
    //             $registrationForms = $schedule->registrationForms;
    //             foreach ($registrationForms as $registrationForm) {
    //                 // echo $registrationForm->id;
    //                 // echo $registrationForm->registration_date;
    //                 $regForms[] = $registrationForm;
    //                 // access other properties as needed
    //             }
    //         }
    //     // }
    //     // foreach($regForms as $regForm){
    //     //     // $r = new RegistrationForm();
    //     //     // $r = $regForm;
    //     //     // $patient = $r->patient;
    //     //     print_r($regForm);
    //     // }
    //     // return $r; 
        
        
    //     return view('employee.vaccination-registration.index', compact('regForms'));
    // }
    public function index(Request $request)
    {
        $schedules = $this->findImmunizationUnit()->schedules;
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


        $oldInput = $request->all();
        
 
        
        
        return view('employee.vaccination-registration.index', compact('filteredData'));
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
        return view('employee.vaccination-registration.show', compact('reg', 'Y', 'U'));
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


     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirm(Request $request, $id)
    {
        $form = RegistrationForm::find($id);
        RegistrationForm::find($id)->update([
            "status" => 1
        ]);
        SendConfirmRegistrationEmail::dispatch($form);
        if($request->input('old_url')){
            return redirect($request->input('old_url'))->with("status", "Đã xác nhận 1 phiếu đăng ký");
        }

        // return redirect()->route('employee.vaccination.registration')->with("status", "Đã xác nhận 1 phiếu đăng ký");
        return redirect()->back()->with("status", "Đã xác nhận 1 phiếu đăng ký");
        // redirect()->to($request->header('referer'))->with("status", "Đã xác nhận 1 phiếu đăng ký");
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function refuse(Request $request, $id)
    {
        RegistrationForm::find($id)->update([
            "status" => -1
        ]);
        if($request->input('old_url')){
            return redirect($request->input('old_url'))->with("status", "Đã từ chối 1 phiếu đăng ký");
        }
        // return redirect()->route('employee.vaccination.registration')->with("status","Đã từ chối 1 phiếu đăng ký");
        return redirect()->back()->with("status","Đã từ chối 1 phiếu đăng ký");
        
    }


     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirmMany(Request $request)
    {
        $data = $request->input();
        $arrayID = explode(',', $data['IDs']);

        $lenght = count($arrayID);
        $listIds = $arrayID;
        foreach($listIds as $listId){
            $form = RegistrationForm::find($listId);
            RegistrationForm::find($listId)->update([
                "status" => 1
            ]);
            SendConfirmRegistrationEmail::dispatch($form);
        }
        // return redirect()->route('employee.vaccination.registration')->with("status","Đã xác nhận $lenght phiếu đăng ký");
        return redirect()->back()->with("status","Đã xác nhận $lenght phiếu đăng ký");
      
    }
}
