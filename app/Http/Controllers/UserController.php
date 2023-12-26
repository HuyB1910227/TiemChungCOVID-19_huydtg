<?php

namespace App\Http\Controllers;
use Illuminate\Support\Carbon;
use App\RegistrationForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use PhpParser\Node\Expr\FuncCall;
use App\Schedule;
use App\Patient;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Process\Process;

class UserController extends Controller
{
    function __construct()
    {
        
        // $this->middleware('auth');
        // $this->middleware('CheckRole:patient');
    }
    public function home() {
        // $patient = Auth::user()->patient;
        // $regs = -1;
        $regAll = -1;
        $patient = Auth::guard('patient')->user();
        $regAll = $patient->registrationForms->where('status', '=', 1)->all();
       
        if($regAll == -1) {
            return view('home-page', compact('patient', 'regs'));
        } 
        foreach($regAll as $reg) {
            if(strtotime($reg->schedule->vaccination_date) >= time()) {
                $regs[] = $reg;
            }    
        }
        if(empty($regs)) {
            $regs = -1;
        }
        // return $regs;
        // return time();
        //
        $process = [
            'basic' => 0,
            'ex_basic' => 0,
            'booster' => 0,
        ];
        $numberOfinjections = count($patient->vaccinationHistories);
        $theLastVaccination = $patient->vaccinationHistories->last();
        if (!isset($theLastVaccination)) {
            return view('home-page', compact('patient', 'regs', 'process'));
        }
        $theLastVaccineInjection = $theLastVaccination->vaccineLot->vaccine;
        if ($patient->required_additional_dose == 1) {
            if ($numberOfinjections < $theLastVaccineInjection->basic_dose) {
                $process = [
                    'basic' => 0,
                    'ex_basic' => 0,
                    'booster' => 0,
                ];
            } else if ($numberOfinjections == $theLastVaccineInjection->basic_dose) {
                $process = [
                    'basic' => 1,
                    'ex_basic' => 0,
                    'booster' => 0,
                ];
            }
            else if ($numberOfinjections < $theLastVaccineInjection->basic_dose + $theLastVaccineInjection->additional_dose) {
                $process = [
                    'basic' => 1,
                    'ex_basic' => 0,
                    'booster' => 0,
                ];
            } else if ($numberOfinjections == $theLastVaccineInjection->basic_dose + $theLastVaccineInjection->additional_dose) {
                $process = [
                    'basic' => 1,
                    'ex_basic' => 1,
                    'booster' => 0,
                ];
            } else {
                $process = [
                    'basic' => 1,
                    'ex_basic' => 1,
                    'booster' => 1,
                ];
            }
        } else {
            if ($numberOfinjections < $theLastVaccineInjection->basic_dose) {
                $process = [
                    'basic' => 0,
                    'ex_basic' => 0,
                    'booster' => 0,
                ];
            } else if ($numberOfinjections == $theLastVaccineInjection->basic_dose) {
                $process = [
                    'basic' => 1,
                    'ex_basic' => 0,
                    'booster' => 0,
                ];
            }
             else {
                $process = [
                    'basic' => 1,
                    'ex_basic' => 0,
                    'booster' => 1,
                ];
            }
        }
        return view('home-page', compact('patient', 'regs', 'process'));
    }

    public function schedule() {
        return view('vaccination-schedule');
    }

    public function regHistory () {
        //$patient = Auth::user()->patient;
        $patient = Auth::guard('patient')->user();
        $regs = $patient->registrationForms;
        return view('registration-management', compact('patient', 'regs'));
    }

    public function profile() {
        return view('profile');
    }

    public function vacCertificate () {
        // $patient = Auth::user()->patient;
        $patient = Auth::guard('patient')->user();
        return view('vaccination-certificate', compact('patient'));
    }

    public function account() {
        $patient = Auth::guard('patient')->user();
        return view('account', compact('patient'));
    }

    public function regVaccination () {
        
        return view('register-vaccination');
    }

    public function vacHistory() {
        // $patient = Auth::user()->patient;
        $patient = Auth::guard('patient')->user();
        $histories = $patient->vaccinationHistories;
        return view('vaccination-history', compact('patient', 'histories'));
    }

    public function index() {
        // $timezone = 'Asia/Ho_Chi_Minh';
        $schedules = Schedule::where('vaccination_date', '>=', date("Y-m-d"))->get();

        return view('index', compact('schedules'));
        // return Carbon::today($timezone);
        // return now($timezone);
        // return Carbon::now('UTC')->setTimezone('Asia/Ho_Chi_Minh');
    }

    
    /** @var App\Models\Patient $patient */
    public function accountUpdate(Request $request) {
        $data = $request->input();
        $patient = Auth::guard('patient')->user();
        $exceptId = $patient->id;
        if(!isset($data['changePass'])) {
            $request->validate(
                [
                    'identify_card' => "required|string|between:8,15|unique:patients,identify_card,$exceptId",
                ],
                [
                    'required' => 'chưa nhập :attribute!',
                    'max' => ':attribute phải bé hơn hoặc bằng :max ký tự!',
                    'min' => ':attribute phải lớn hơn hoặc bằng :min ký tự!',
                    'email' => ':attribute không hợp lệ!',
                    'unique' => ':attribute đã được sử dụng!',
                    'digits_between' => ':attribute không hợp lệ!',
                    'between' => ':attribute không hợp lệ!',
                    'before' => 'Yêu cầu từ 18 tuổi trở lên',
                    'identify_card' =>  ':attribute phải là kiểu số!',
                ],
                [
                    'identify_card' => 'CCCD/CMND/BHYT',
                    // 'password' => 'mật khẩu',
                ]
            );
            Patient::find(Auth::guard('patient')->id())->update([
                'identify_card' => $request->identify_card,
            ]);
            return redirect()->route('patient.account')->with('success', 'Cập nhật tên tài khoản thành công!');
        } 
        
        if(Hash::check($data['password'], $patient->password)){
            $this->validator($data);
            Patient::find(Auth::guard('patient')->id())->update([
                'identify_card' => $data['identify_card'],
                'password' => Hash::make($data['npwd'])
            ]);
            return redirect()->route('patient.account')->with('success', 'Cập nhật tài khoản thành công!');
        } else {
            return redirect()->route('patient.account')->with('fail', 'Mật khẩu đăng nhập không chính xác');
        }
        return Hash::make($data['password']);
    }
}
