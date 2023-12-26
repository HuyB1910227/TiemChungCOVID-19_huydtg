<?php

namespace App\Http\Controllers;

use App\Administrator;
use App\Employee;
use App\User;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProfileUserController extends Controller
{
    public function authenticatedUser ($id) {
        $user = User::find($id);
        
        if($user->hasRole('administrator')) {
            $details = $user->administrator;
        } elseif ($user->hasRole('employee') || $user->hasRole('manager')){
            $details = $user->employee;
        }
        return $details;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {   
        $user = User::find($id);
       
        $details = $this->authenticatedUser($id);
        return view('manager-employee.profile.index', compact('user', 'details'));
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
        $data = $request->input();
        $user = User::find(Auth::user()->id);
        if($user->hasRole('administrator')) {
            $model = Administrator::find($id);

            $request->validate(
                [   
                    'identify_card' => "unique:administrators,identify_card,$model->id",
                    'phone' => "unique:administrators,phone,$model->id",
                ],
                [
                    
                    'unique' => ":attribute đã được sử dụng."
                ],
                [
                    'identify_card' => "CCCD/CMND",
                    'phone' => "Số điện thoại",
                ]
            );
            $user->update([
                'name' => $data['full_name'],
            ]);
            $model->update([
                'full_name' => $data['full_name'], 
                'identify_card' => $data['identify_card'], 
                'phone' => $data['phone'], 
                'date_of_birth' => $data['date_of_birth'], 
                'gender' => $data['gender'], 
                'address' => $data['address']." ; ".$data['village']." ; ".$data['district']." ; ".$data['province'], 
            ]);
            $details = $user->administrator;
        } elseif ($user->hasRole('employee') || $user->hasRole('manager')){
            $model = Employee::find($id);
            $request->validate(
                [   
                    'identify_card' => "unique:employees,identify_card,$model->id",
                    'phone' => "unique:employees,phone,$model->id",
                ],
                [
                    
                    'unique' => ":attribute đã được sử dụng."
                ],
                [
                    'identify_card' => "CCCD/CMND",
                    'phone' => "Số điện thoại",
                ]
            );
            $user->update([
                'name' => $data['full_name'],
            ]);
            $model->update([
                'full_name' => $data['full_name'], 
                // 'employee_id' => $data['employee_id'], 
                'identify_card' => $data['identify_card'], 
                'phone' => $data['phone'], 
                'date_of_birth' => $data['date_of_birth'], 
                'gender' => $data['gender'], 
                'address' => $data['address']." ; ".$data['village']." ; ".$data['district']." ; ".$data['province'], 
            ]);
            $details = $user->employee;
            // return print_r("yes");
        }
        return redirect()->back();
        
    }


    public function updateAvatar(Request $request, $id)
    {
        
        $image = false;
        $image = $request->file('fileToUpload');
        if($image){
            $filename = date("YmdHis_").$image->getClientOriginalName();
            $path = $image->move('public/admin/img/uploads', $filename);
            $pathImage = $path->getPathname();
            $pathImage = str_replace("public/", "", $pathImage);
            $pathImage = str_replace("\\", "/", $pathImage);
        }
        if($path) {
            Administrator::where('user_id', $id)->update([
                'avatar' => $pathImage,
            ]);
            Employee::where('user_id', $id)->update([
                'avatar' => $pathImage,
            ]);
            $details = $this->authenticatedUser($id);
            return redirect()->back();
        }
        $details = $this->authenticatedUser($id);
        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
