<?php

namespace App\Http\Controllers;

use App\BoosterVaccine;
use App\Type;
use App\Vaccine;
use Illuminate\Http\Request;

class VaccineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vaccines = Vaccine::all();
        $types = Type::all();
        return view('admin.vaccine.index', compact('vaccines', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $vaccines = Vaccine::all();
        return view('admin.vaccine.create', compact('types', 'vaccines'));
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
            'name' => 'required|string|max:255',
            'basic_dose' => 'required|integer|gte:1',
            'basic_injections_interval' => 'required|integer|gte:14|lte:200',
            'additional_dose' => 'required|integer|gte:0',
            'additional_injections_interval' => 'required|integer|gte:0',
            'type_id' => 'required'
        ],
        [
            'required' => 'chưa nhập :attribute!',
            'max' => ':attribute phải bé hơn hoặc bằng 255 ký tự!',
            'integer' => ':attribute phải là chữ số',
            'gte' => ':attribute phải lớn hơn :value ',
            'lte' => ':attribute phải nhỏ hơn :value '
        ],
        [
            'name' => 'tên vắc xin',
            'basic_dose' => 'số mũi tiêm cơ bản',
            'basic_injections_interval' => 'khoảng các giữa các mũi cơ bản',
            'additional_dose' => 'số mũi tiêm bổ sung',
            'additional_injections_interval' => 'khoảng cách giữa các mũi tiêm bổ sung',
            'type_id' => 'loại'

        ]);
        $data = $request->input();
        $newVaccine = Vaccine::create([
            'name' => $data['name'],
            'basic_dose' => $data['basic_dose'],
            'basic_injections_interval' => $data['basic_injections_interval'],
            'additional_dose' => $data[ 'additional_dose'],
            'additional_injections_interval' => $data['additional_injections_interval'],
            'type_id' => $data['type_id']
        ]);
        if($newVaccine) {
            if(!empty($data['list_vaccine_id'])){
                foreach($data['list_vaccine_id'] as $appropriate_vaccine_id){
                    BoosterVaccine::create([
                        'vaccine_id' => $newVaccine->id, 
                        'appropriate_vaccine_id' => $appropriate_vaccine_id
                    ]);
                };
            }
            return redirect()->route('admin.vaccine')->with('status', 'Đã thêm 1 vắc xin');
        }
        return redirect()->route('admin.vaccine')->with('status', 'Đã thêm 1 vắc xin');
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
        $types = Type::all();
        $vaccine = Vaccine::find($id);
        $vaccines = Vaccine::all();
        $selectedVaccines = $vaccine->boosterVaccines;
        foreach($selectedVaccines as $selectedVaccine) {
            $selectedVaccineIds[] = $selectedVaccine->id;
        }
        if(empty($selectedVaccineIds)) {
            $selectedVaccineIds[] = -1;
        }
        return view('admin.vaccine.update', compact('vaccine', 'types', 'vaccines', 'selectedVaccineIds'));
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
            'name' => 'required|string|max:255',
            'basic_dose' => 'required|integer|gte:1',
            'basic_injections_interval' => 'required|integer|gte:14|lte:200',
            'additional_dose' => 'required|integer|gte:0',
            'additional_injections_interval' => 'required|integer|gte:0',
            'type_id' => 'required'
        ],
        [
            'required' => 'chưa nhập :attribute!',
            'max' => ':attribute phải bé hơn hoặc bằng :max ký tự!',
            'integer' => ':attribute phải là chữ số',
            'gte' => ':attribute phải lớn hơn hoặc bằng :value ',
            'lte' => ':attribute phải nhỏ hơn hoặc bằng :value',
            
        ],
        [
            'name' => 'tên vắc xin',
            'basic_dose' => 'số mũi tiêm cơ bản',
            'basic_injections_interval' => 'khoảng các giữa các mũi cơ bản',
            'additional_dose' => 'số mũi tiêm bổ sung',
            'additional_injections_interval' => 'khoảng cách giữa các mũi tiêm bổ sung',
            'type_id' => 'loại'

        ]);
        $data = $request->input();
        
        $updateVaccine = Vaccine::find($id)->update([
            'name' => $data['name'],
            'basic_dose' => $data['basic_dose'],
            'basic_injections_interval' => $data['basic_injections_interval'],
            'additional_dose' => $data[ 'additional_dose'],
            'additional_injections_interval' => $data['additional_injections_interval'],
            'type_id' => $data['type_id']
        ]);
        if ($updateVaccine) {
            BoosterVaccine::where('vaccine_id', $id)->delete();
            if(!empty($data['list_vaccine_id'])){
                foreach($data['list_vaccine_id'] as $appropriate_vaccine_id){
                    BoosterVaccine::create([
                        'vaccine_id' => $id, 
                        'appropriate_vaccine_id' => $appropriate_vaccine_id
                    ]);
                };
            }
            return redirect()->route('admin.vaccine')->with('status', 'Đã cập nhật 1 vắc xin');
        }
        return redirect()->route('admin.vaccine')->with('status', 'Đã cập nhật 1 vắc xin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Vaccine::find($id)->delete();
        return redirect()->route('admin.vaccine')->with('status', 'Đã xóa 1 vắc xin');
    }
}
