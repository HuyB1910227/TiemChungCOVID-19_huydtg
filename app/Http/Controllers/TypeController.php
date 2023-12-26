<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Type;
use Illuminate\Auth\Events\Validated;
use App\Http\Controllers\Validator;
use Illuminate\Support\MessageBag;
class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Type::all();
        return view ('admin.vaccination-type.index', compact('types'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.vaccination-type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'txtTenLoaiVaccine' => 'required|string|max:255',
            // 'txtMota' => 'required'
            
        ],
        [
            'required' => 'Chưa nhập :attribute!',
            'max' => ':attribute phải bé hơn hoặc bằng 255 ký tự!'
        ],
        [
            'txtTenLoaiVaccine' => 'tên loại vắc xin',

        ]);
        $data = $request->input();
        Type::create([
            'name' => $data['txtTenLoaiVaccine'],
            'description' => $data['txtMoTa']
        ]);
        return redirect()->route('admin.type')->with('status', 'Đã thêm 1 loại vắc xin');
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
        $type = Type::find($id);
        // return 'hi';
        return view('admin.vaccination-type.update', compact('type'));
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
        $request->validate([
            'txtTenLoaiVaccine' => 'required|max:255',
            
        ],
        [
            'required' => 'Chưa nhập :attribute!',
            'max' => ':attribute phải bé hơn hoặc bằng 255 ký tự!'
        ],
        [
            'txtTenLoaiVaccine' => 'tên loại vắc xin',

        ]);
      
        $data = $request->input();
        Type::find($id)->update([
            'name' => $data['txtTenLoaiVaccine'],
            'description' => $data['txtMoTa']
        ]);
        
        return redirect()->route('admin.type')->with('status', 'Đã cập nhật 1 loại vắc xin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Type::find($id)->delete();
        return redirect()->route('admin.type')->with('status', 'Đã xóa 1 loại vắc xin');
    }
}
