<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\ImmunizationUnit;
use App\Vaccine;
use App\VaccineLot;

class ManagerVaccineLotController extends Controller
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
    public function index()
    {
        $lots = $this->findImmunizationUnit()->lots;
        return view('manager.storage.index', compact('lots'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'lot_code' => ['required'],
            'quantity' => ['required', 'numeric'],
            'manufacturing_date' => ['required', 'before:'.date('Y-m-d')],
            'transaction_date' => ['required', 'before:'.date('Y-m-d', strtotime('+1 days')), 'after:manufacturing_date'],
            'expired_date' => ['required', 'after:transaction_date'],
            'vaccine' => ['required'],

        ],
        [
            'required' => 'chưa nhập :attribute!',
            'numeric' => ':attribute phải thuộc kiểu số!',
            'manufacturing_date.before' => ':attribute phải trước ngày: '.date('Y-m-d'),
            'transaction_date.before' => ':attribute phải trước ngày: :date',
            'after' => ':attribute phải sau ngày :date'
        ],
        [
            'lot_code' => 'mã lô vắc xin',
            'quantity' => 'số lượng',
            'manufacturing_date' => 'ngày sản xuất',
            'transaction_date' => 'ngày nhập kho',
            'expired_date' => 'ngày hết hạn',
            'vaccine' => 'vắc xin',
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
        $vaccines = Vaccine::all();
        return view('manager.storage.create', compact('vaccines'));
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
        VaccineLot::create([
            'lot_code' => $data['lot_code'],
            'quantity' => $data['quantity'],
            'manufacturing_date' => $data['manufacturing_date'],
            'transaction_date' => $data['transaction_date'],
            'expired_date' => $data['expired_date'], 
            'vaccine_id' => $data['vaccine'],
            'immunization_unit_id'=> $this->findImmunizationUnitId()
        ]);

        session()->flash('status', "Đã thêm 1 lô vắc xin vào hệ thống!");
        return redirect()->route('manager.lot');

        

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
        $lot = VaccineLot::find($id);
        $vaccines = Vaccine::all();
        return view('manager.storage.edit', compact('vaccines', 'lot'));
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
        VaccineLot::find($id)->update([
            'lot_code' => $data['lot_code'],
            'quantity' => $data['quantity'],
            'manufacturing_date' => $data['manufacturing_date'],
            'transaction_date' => $data['transaction_date'],
            'expired_date' => $data['expired_date'], 
            'vaccine_id' => $data['vaccine'],
            'immunization_unit_id'=> $this->findImmunizationUnitId()
        ]);

        session()->flash('status', 'Đã cập nhật 1 lô vắc xin trong hệ thống!');
        return redirect()->route('manager.lot');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        VaccineLot::find($id)->delete();
        session()->flash('status', 'Đã xóa 1 lô vắc xin trong hệ thống!');
        return redirect()->route('manager.lot');
    }
}
