<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;



class AccountController extends Controller
{
    public function changePassword(){
        return view('manager-employee.account.password');
    }

    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
          
            
    //         'password' => ['required', 'string', 'min:8'],
    //         'npwd' => ['required', 'string', 'min:8'],
    //         're_npwd' => ['required', 'same:npwd'],
            

    //     ],
    //     [
    //         'required' => 'chưa nhập :attribute!',
    //         'max' => ':attribute phải bé hơn hoặc bằng :max ký tự!',
    //         'min' => ':attribute phải lớn hơn hoặc bằng :min ký tự!',
    //         'email' => ':attribute không hợp lệ!',
    //         'unique' => ':attribute đã được sử dụng!',
    //         'digits_between' => ':attribute phải từ :minimum đến :maximum!',
    //         'before' => 'Yêu cầu từ 18 tuổi trở lên',
    //         'identify_card' =>  ':attribute phải là kiểu số!',
    //     ],
    //     [
    //         'name' => 'tên đăng nhập',
    //         'password' => 'mật khẩu',

            
            
    //     ]
    //     );
    // }
    
    public function updatePassword(Request $request) {
        
        $user = Auth::user();
        
        $request->validate([
            'password' => ['required', 'string', 'min:8'],
            'npwd' => ['required', 'string', 'min:8'],
            're_npwd' => ['required', 'same:npwd'],
        ], [
            'required' => 'chưa nhập :attribute!',
            'max' => ':attribute phải bé hơn hoặc bằng :max ký tự!',
            'min' => ':attribute phải lớn hơn hoặc bằng :min ký tự!',
            'email' => ':attribute không hợp lệ!',
            'unique' => ':attribute đã được sử dụng!',
            'digits_between' => ':attribute phải từ :minimum đến :maximum!',
            'before' => 'Yêu cầu từ 18 tuổi trở lên',
            'identify_card' => ':attribute phải là kiểu số!',
        ], [
            'name' => 'tên đăng nhập',
            'password' => 'mật khẩu',
            'npwd' => "mật khẩu mới",
            're_npwd' => "nhập lại mật khẩu mới"

        ]);
        $data = $request->input();
        
        if(Hash::check($data['password'], $user->password)){
           
            User::find(Auth::id())->update([
                'password' => Hash::make($data['npwd'])
            ]);
            return redirect()->back()->with('success', 'Cập nhật tài khoản thành công!');
            // /** @var App\Models\User $user */
            // if($user->hasRole('administrator')){
            //     return redirect()->route('admin.password')->with('success', 'Cập nhật tài khoản thành công!');
            // } elseif ($user->hasRole('manager')){
            //     return redirect()->route('manager.password')->with('success', 'Cập nhật tài khoản thành công!');
            // } 
            // elseif ($user->hasRole('employee')){
            //     return redirect()->route('employee.password')->with('success', 'Cập nhật tài khoản thành công!');
            // }
        } else {
            return redirect()->back()->with('fail', 'Mật khẩu đăng nhập không chính xác');
        }
        // /** @var App\Models\User $user */
        // if($user->hasRole('administrator')){
        //     return redirect()->route('admin.password')->with('success', 'Cập nhật tài khoản thành công!');
        // } elseif ($user->hasRole('manager')){
        //     return redirect()->route('manager.password')->with('success', 'Cập nhật tài khoản thành công!');
        // } 
        // elseif ($user->hasRole('employee')){
        //     return view('manager-employee.account.password')->with('success', 'Cập nhật tài khoản thành công!')->withInput();
        // }
        return redirect()->back()->with('fail', 'Mật khẩu đăng nhập không chính xác');
       
        
    }
}
