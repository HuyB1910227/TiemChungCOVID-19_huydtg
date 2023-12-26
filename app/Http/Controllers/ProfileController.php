<?php

namespace App\Http\Controllers;

use App\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patient = Auth::guard('patient')->user();
        return view('profile', compact('patient'));
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
        $patient = Patient::find($id);
        $request->validate(
            [   
                'email' => "unique:patients,email,$patient->id",
                'telSDT' => "unique:patients,phone,$patient->id",
            ],
            [
                'required' => 'chưa nhập :attribute!',
                'max' => ':attribute phải bé hơn hoặc bằng 255 ký tự!',
                'integer' => ':attribute phải là chữ số',
                'gte' => ':attribute phải lớn hơn 14 ngày',
                'lte' => ':attribute phải nhỏ hơn 100 ngày',
                'unique' => ":attribute đã được sử dụng."
            ],
            [
                'email' => "Email",
                'telSDT' => "Số điện thoại",
            ]
        );
        $data = $request->all();
        Patient::find($id)->update([
            'full_name' => $data['txtHoTen'], 
            // 'identify_card' => $data['txtCCCD'], 
            'address' => $data['txtDiaChi']." ; ".$data['txtPX']." ; ".$data['txtQH']." ; ".$data['txtTP'], 
            'phone' => $data['telSDT'], 
            'gender' => $data['rdGioiTinh'], 
            'date_of_birth' => $data['dtNgaySinh'], 
            'career' => $data['txtNgheNghiep'],
        ]);
        return redirect()->route('profile')->with("status", "Đã cập nhật thông tin cá nhân!");
    }
    public function updateAvatar(Request $request, $id)
    {
        
        $image = false;
        $image = $request->file('fileToUpload');
        if($image){
            $filename = date("YmdHis_").$image->getClientOriginalName();
            $path = $image->move('public/user/img/uploads', $filename);
            // return var_dump($filename);
            $pathImage = $path->getPathname();
            $pathImage = str_replace("public/", "", $pathImage);
            $pathImage = str_replace("\\", "/", $pathImage);
        }
        if($path) {
            Patient::find($id)->update([
                'avatar' => $pathImage,
            ]);
            return redirect()->route('profile')->with("status", "Đã cập nhật ảnh đại diện!");
        }
        return redirect()->route('profile')->with("status", "Không thể cập nhật ảnh đại diện!");
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
