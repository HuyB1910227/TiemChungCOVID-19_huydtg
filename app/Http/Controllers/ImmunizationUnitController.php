<?php

namespace App\Http\Controllers;

use App\ImmunizationUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ImmunizationUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $immunizationUnits = ImmunizationUnit::all();
        return view('admin.immunization-unit.index',compact('immunizationUnits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.immunization-unit.create');
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
        ImmunizationUnit::create([
            'name' => $data['name'],
            'address' => $data['address']." ; ".$data['village']." ; ".$data['district']." ; ".$data['province'],
            'operating_license' => $data['operating_license'],
            'hotline' => $data['hotline'],
            'status' => $data['status'],
        ]);
        return redirect()->route('admin.immunizationUnit')->with('status', 'Đã thêm 1 cơ sở');
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
        $immunizationUnit = ImmunizationUnit::find($id);
        $addressOfIU = explode(' ; ', $immunizationUnit->address);
        return view('admin.immunization-unit.edit', compact('immunizationUnit', 'addressOfIU'));
        
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'min:8'],
            'district' => ['required'],
            'village' => ['required'],
            'province' => ['required'],
            'address' => ['required'],
            'hotline' => ['required'],
            'operating_license' => ['required', 'string', 'max:255', 'min:8'],

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
        ],
        [
            'name' => 'tên cơ sở',
            'district' => 'Quận / Huyện',
            'village' => 'Phường / Xã',
            'province' => 'Thành / Phố',
            'address' => 'địa chỉ',
            'hotline' => 'số điện thoại',
            'operating_license' => 'mã số giấy phép hoạt động'
        ]
        );
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
        $this->validator($data)->validate();
        ImmunizationUnit::find($id)->update([
            'name' => $data['name'],
            'address' => $data['address']." ; ".$data['village']." ; ".$data['district']." ; ".$data['province'],
            'operating_license' => $data['operating_license'],
            'hotline' => $data['hotline'],
            'status' => $data['status'],
        ]);
        return redirect()->route('admin.immunizationUnit')->with('status', 'Đã cập nhật 1 cơ sở');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ImmunizationUnit::find($id)->delete();
        return redirect()->route('admin.immunizationUnit')->with('status', 'Đã xóa 1 cơ sở');
        
    }
}
