<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


use App\Employee;
use App\ImmunizationUnit;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Mail\CreatedUserAccount;
use App\Role;

class ManagerMemberController extends Controller
{
    function generateRandomString($length = 10) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
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
        
        // $employees = Employee::where();
        $employees = $this->findImmunizationUnit()->employees;
        return view('manager.member.index', compact('employees'));
        return $this->findImmunizationUnitId();
        // return "hi";
    }

    

    protected function validator(array $data)
    {
        return Validator::make($data, [
    
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'full_name' => ['required', 'string', 'min:5', 'max:255'],
            'identify_card' => ['required', 'regex:/^\d{8}$|^\d{9}$|^\d{12}$/', 'unique:employees'],
            'district' => ['required'],
            'village' => ['required'],
            'province' => ['required'],
            'address' => ['required'],
            'phone' => ['required'],
            'gender' => ['required'],
            'date_of_birth' => ['required', 'date', 'before:'.date('Y-m-d', strtotime('-18 years'))],
            'employee_id' => ['required'],
            
        ],
        [
            'required' => 'chưa nhập :attribute!',
            'max' => ':attribute phải bé hơn hoặc bằng :max ký tự!',
            'min' => ':attribute phải lớn hơn hoặc bằng :min ký tự!',
            'email' => ':attribute không hợp lệ!',
            'unique' => ':attribute đã được sử dụng!',
            'digits_between' => ':attribute phải từ :minimum đến :maximum!',
            'before' => 'Yêu cầu từ 18 tuổi trở lên',
            'identify_card' =>  ':attribute phải là kiểu số!',
            'identify_card.regex' => "CCCD/CMDN phải có độ dài 8 hoặc 9 hoặc 12 chữ số"
        ],
        [
            'name' => 'tên đăng nhập',
            
            'full_name' => 'họ và tên',
            'identify_card' => 'chứng minh nhân dân / căn cước công dân',
            'district' => 'Quận / Huyện',
            'village' => 'Phường / Xã',
            'province' => 'Thành / Phố',
            'address' => 'địa chỉ',
            'phone' => 'số điện thoại',
            'gender' => 'giới tính',
            'date_of_birth' => 'ngày sinh',
            'employee_id' => 'mã nhân viên',
            'immunization_unit' => 'đơn vị tiêm chủng'
        ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manager.member.create');
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
        $this->validator($data)->validate();
        $head = $this->generateRandomString(4);
        $body = substr($data['identify_card'], -4);
        $foot = substr($data['employee_id'], -4);
        $user = User::create([
            'name' => $data['full_name'],
            'email' => $data['email'],
            'password' => Hash::make($head.$body.$foot), 
            
        ]);

        if($user) {
            DB::insert('insert into role_user (user_id, role_id) values (?, ?)', [$user->id, 4]);
            Employee::create([
                'full_name' => $data['full_name'], 
                'employee_id' => $data['employee_id'], 
                'identify_card' => $data['identify_card'], 
                'phone' => $data['phone'], 
                'date_of_birth' => $data['date_of_birth'], 
                'gender' => $data['gender'], 
                'address' => $data['address']." ; ".$data['village']." ; ".$data['district']." ; ".$data['province'], 
                'user_id' => $user->id,  
                'immunization_unit_id' => $this->findImmunizationUnitId(),
                
            ]);
        }
        // Mail::to($user->email)->send(new CreatedUserAccount($user));
        $data = [
            'name' => $user->name,
            'passwordHead' => $head,
            'passwordBody' => $body,
            'passwordFoot' => $foot,
        ];
        Mail::to($user->email)->send(new CreatedUserAccount($data));
        return redirect('ban-quan-ly/thanh-vien')->with('status' , 'Đã thêm 1 thành viên vào hệ thống');
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
        $employee = Employee::find($id);
        $user = User::find($employee->user_id);
        // $immunizationUnits = ImmunizationUnit::all();
        $addressOfE = explode(' ; ', $employee->address);
        return view('manager.member.edit', compact('employee', 'addressOfE', 'user'));
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
        // $this->validator($data)->validate();
        $employee = Employee::find($id);
        $user = User::find($employee->user_id);
        $request->validate(
            [
                'email' => ['required', 'string', 'email', 'max:255',($data['email'] === $user->email) ? '' : 'unique:users'],
                'full_name' => ['required', 'string', 'min:5', 'max:255'],
                'identify_card' => ['required', 'regex:/^\d{8}$|^\d{9}$|^\d{12}$/',($data['identify_card'] === $employee->identify_card) ? '' : 'unique:employees'],
                'district' => ['required'],
                'village' => ['required'],
                'province' => ['required'],
                'address' => ['required'],
                'phone' => ['required'],
                'gender' => ['required'],
                'date_of_birth' => ['required', 'date', 'before:'.date('Y-m-d', strtotime('-18 years'))],
                'employee_id' => ['required'],
                
            ],
            [
                'required' => 'chưa nhập :attribute!',
                'max' => ':attribute phải bé hơn hoặc bằng :max ký tự!',
                'min' => ':attribute phải lớn hơn hoặc bằng :min ký tự!',
                'email' => ':attribute không hợp lệ!',
                'unique' => ':attribute đã được sử dụng!',
                'digits_between' => ':attribute phải từ :minimum đến :maximum!',
                'before' => 'Yêu cầu từ 18 tuổi trở lên',
                'identify_card' =>  ':attribute phải là kiểu số!',
                'identify_card.regex' => "CCCD/CMDN phải có độ dài 8 hoặc 9 hoặc 12 chữ số"
            ],
            [
                'name' => 'tên đăng nhập',
               
                'full_name' => 'họ và tên',
                'identify_card' => 'chứng minh nhân dân / căn cước công dân',
                'district' => 'Quận / Huyện',
                'village' => 'Phường / Xã',
                'province' => 'Thành / Phố',
                'address' => 'địa chỉ',
                'phone' => 'số điện thoại',
                'gender' => 'giới tính',
                'date_of_birth' => 'ngày sinh',
                'employee_id' => 'mã nhân viên',
                'immunization_unit' => 'đơn vị tiêm chủng'
            ]
        );
        $user->update([
            'name' => $data['full_name'],
            'email' => $data['email'],
        ]);
        
        if($user) {
           
            $employee->update([
                'full_name' => $data['full_name'], 
                'employee_id' => $data['employee_id'], 
                'identify_card' => $data['identify_card'], 
                'phone' => $data['phone'], 
                'date_of_birth' => $data['date_of_birth'], 
                'gender' => $data['gender'], 
                'address' => $data['address']." ; ".$data['village']." ; ".$data['district']." ; ".$data['province'], 
                
            ]);
        }
        return redirect('ban-quan-ly/thanh-vien')->with('status' , 'Đã cập nhât 1 thành viên trong hệ thống');
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
