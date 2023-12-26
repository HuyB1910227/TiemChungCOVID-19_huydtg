<?php

namespace App\Http\Controllers\Auth;
namespace App\Http\Controllers\Patient;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Patient;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = 'nguoi-dan/dang-nhap';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:patient')->except('logout');
    }

    // /**
    //  * Get a validator for an incoming registration request.
    //  *
    //  * @param  array  $data
    //  * @return \Illuminate\Contracts\Validation\Validator
    //  */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            // 'name' => ['required', 'string', 'max:255', 'min:8', 'unique:patients'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:patients'],
            'password' => ['required', 'string', 'min:8'],
            'password_confirm' => ['required', 'same:password'],
            'full_name' => ['required', 'string', 'min:5', 'max:255'],
            'identify_card' => ['required', 'between:9,15', 'unique:patients'],
            'txtQH' => ['required'],
            'txtPX' => ['required'],
            'txtTP' => ['required'],
            'txtDiaChi' => ['required'],
            'phone' => ['required', 'digits_between:9,11', 'unique:patients'],
            'gender' => ['required'],
            'date_of_birth' => ['required', 'date', 'before:'.date('Y-m-d', strtotime('-14 years'))],

        ],
        [
            'required' => 'chưa nhập :attribute!',
            'max' => ':attribute phải bé hơn hoặc bằng :max ký tự!',
            'min' => ':attribute phải lớn hơn hoặc bằng :min ký tự!',
            'email' => ':attribute không hợp lệ!',
            'unique' => ':attribute đã được sử dụng!',
            'between' => ':attribute không hợp lệ!',
            'digits_between' => ':attribute không hợp lệ!',
            'before' => 'Yêu cầu từ 18 tuổi trở lên',
            'identify_card' =>  ':attribute phải là kiểu số!',
            "password_confirm.same" => 'Mật khẩu và nhập lại mật khẩu không trùng khớp'
        ],
        [
            // 'name' => 'tên đăng nhập',
            'password' => 'mật khẩu',
            'password_confirm' => 'nhập lại mật khẩu',
            'full_name' => 'họ và tên',
            'identify_card' => 'Chứng minh nhân dân / Căn cước công dân / Bảo hiểm y tế',
            'txtQH' => 'Quận / Huyện',
            'txtPX' => 'Phường / Xã',
            'txtTP' => 'Thành / Phố',
            'txtDiaChi' => 'địa chỉ',
            'phone' => 'số điện thoại',
            'gender' => 'giới tính',
            'date_of_birth' => 'ngày sinh',
        ]
        );
    }

    public function createPatient(Request $request)
    {
        
        $data = $request->all();
        $this->validator($data)->validate();
        $patient = Patient::create([
            // 'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'full_name' => $data['full_name'], 
            'identify_card' => $data['identify_card'],
            'address' => $data['txtDiaChi'].' ; '.$data['txtQH'].' ; '.$data['txtPX'].' ; '.$data['txtTP'],
            'phone' => $data['phone'],
            'gender' => $data['gender'],
            'date_of_birth' => $data['date_of_birth'],
            'career' => $data['career'],
          
            
        ]);
        // if(auth('patient')->attempt(['email' => $data['email'],'password' => $data['password']])){
        //     $patient->sendEmailVerificationNotification();
        //     return redirect()->intended('nguoi-dan/email/verify');
        // }
        return redirect()->intended('nguoi-dan/dang-nhap')->with('status', 'Đăng ký tài khoản thành công, vui lòng đăng nhập để sử dụng dịch vụ của chúng tôi!');
        
        
    }

    public function showPatientRegisterForm()
    {
        return view('patient.auth.register');
    }
}
