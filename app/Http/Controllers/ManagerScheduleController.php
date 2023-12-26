<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Group;
use App\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\ImmunizationUnit;
use App\Vaccine;
// use PhpParser\Node\Expr\Cast\Array_;

class ManagerScheduleController extends Controller
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
    public function index(Request $request)
    {
        $vaccines = Vaccine::all();
        $schedules = $this->findImmunizationUnit()->schedules;
        // $schedules = $allSchedules;
        if ($request->filled('status')) {
            $status = $request->input('status');
            $schedules = $schedules->where('status', $status);
        }

        if ($request->filled('vaccination_date')) {
            $vaccination_date = $request->input('vaccination_date');
            $schedules = $schedules->where('vaccination_date', $vaccination_date);
        }
    
        if ($request->filled('vaccine_id')) {
            $vaccine_id = $request->input('vaccine_id');
            $schedules = $schedules->where('vaccine_id', $vaccine_id);
        }
        return view('manager.schedule.index', compact('schedules', 'vaccines'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vaccines = Vaccine::all();
        // $employees = $this->findImmunizationUnit()->employees;
        return view('manager.schedule.create', compact('vaccines'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'vaccination_date' => ['required', 'after:'.date('Y-m-d', strtotime('-1 days'))],
            'start_time' => ['required'],
            'end_time' => ['required', 'after:start_time'],
            'vaccine' => ['required'],
            'list_employee' => ['required']
        ],
        [
            'required' => 'chưa nhập :attribute!',
            'max' => ':attribute phải bé hơn hoặc bằng :max ký tự!',
            'min' => ':attribute phải lớn hơn hoặc bằng :min ký tự!',
            'email' => ':attribute không hợp lệ!',
            'unique' => ':attribute đã được sử dụng!',
            'digits_between' => ':attribute phải từ :min đến :max!',
            'before' => 'Yêu cầu từ 18 tuổi trở lên',
            'identify_card' =>  ':attribute phải là kiểu số!',
            'end_time.after' => ':attribute phải sau thời gian bắt đầu!',
            'vaccination_date.after' => ':attribute phải sau ngày '.date('d/m/Y', strtotime('-1 days')),
        ],
        [
            'vaccination_date' => 'ngày tiêm',
            'start_time' => 'giờ bắt đầu',
            'end_time' => 'giờ kết thúc',
            'vaccine_id' => 'vaccine',
            'list_employee' => 'danh sách nhân viên'
        ]
        );
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
        // $this->validator($data)->validate();
        $createTime = Schedule::create([
            'vaccination_date'=> $data['vaccination_date'], 
            'start_time'=> $data['start_time'], 
            'end_time'=> $data['end_time'], 
            'status'=> 0, 
            'vaccine_id'=> $data['vaccine'], 
            'immunization_unit_id'=> $this->findImmunizationUnitId()
        ]);
        if($createTime) {
            foreach($data['list_employee'] as $employee_id){
               Group::create([
                    'employee_id' => $employee_id, 
                    'schedule_id' => $createTime->id
               ]);
            };
            return redirect()->route('manager.schedule')->with('status', 'Đã thêm 1 lịch tiêm vào hệ thống!');
        }
        return redirect()->route('manager.schedule')->with('status', 'Đã xảy ra lỗi!');
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employees = [];
        $schedule = Schedule::find($id);
        $groups = $schedule->groups;
        foreach($groups as $group) {
            $employees[] = $group->employee;
        }
        return view('manager.schedule.show', compact('schedule', 'employees'));
        // return var_dump($employees);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $selectedEmployeeIds = [];
        $schedule = Schedule::find($id);
        $vaccines = Vaccine::all();
        $employees = $this->findImmunizationUnit()->employees;
        $selectedGroups = $schedule->groups;
        // $selectedEmployeeIds[] = $selectedEmployees->id;
        foreach($selectedGroups as $selectedGroup){
            $selectedEmployeeIds[] = $selectedGroup->employee->id;
        }
        return view('manager.schedule.edit', compact('schedule', 'vaccines', 'employees', 'selectedEmployeeIds'));
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
        $updateTime = Schedule::find($id)->update([
            'vaccination_date'=> $data['vaccination_date'], 
            'start_time'=> $data['start_time'], 
            'end_time'=> $data['end_time'], 
            'status'=> 0, 
            'vaccine_id'=> $data['vaccine'], 
            'immunization_unit_id'=> $this->findImmunizationUnitId()
        ]);
        if($updateTime) {
            
            Schedule::find($id)->groups()->delete();
            // Group::whereIn('schedule_id', $updateTime->id)->delete();
            foreach($data['list_employee'] as $employee_id){
               Group::create([
                    'employee_id' => $employee_id , 
                    'schedule_id' => $id    
               ]);
            };
            return redirect()->route('manager.schedule')->with('status', 'Đã cập nhật 1 lịch tiêm vào hệ thống!');
        }
        return redirect()->route('manager.schedule')->with('status', 'Đã xảy ra lỗi!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $groups = Schedule::find($id)->groups;
        // foreach($groups as $group) {
        //     $group->delete();
        // }
        Schedule::find($id)->update([
            'status' => -2
        ]);
        return redirect()->back()->with('status', 'Đã hủy 1 lịch tiêm!');

    }

    

    public function findApropriateEmployee(Request $request) {
        // $data = $request->all();
        // $employees = Employee::whereHas('schedules', function($query) use ($data) {
        //     $query->whereNotIn('vaccination_date', $data['vaccination_date'])
        //           ->whereNotBetween('start_time', [$data['start_time'],$data['end_time']])
        //           ->whereNotBetween('end_time', [$data['start_time'], $data['end_time']]);
        // })->get();
        // $employees = $employees->where('immunization_unit_id', $this->findImmunizationUnitId());
        
        // return response()->json([
        //           'success' => true,
        //         ]);
       
    }
    protected function validatorForPrepare(array $data)
    {
        return Validator::make($data, [
            'vaccination_date' => ['required', 'after:'.date('Y-m-d', strtotime('-1 days'))],
            'start_time' => ['required', $data['vaccination_date'] == date('Y-m-d') ?  'after:'.date('H:i:s') : ''],
            'end_time' => ['required', 'after:start_time'],
            'vaccine' => ['required'],
            // 'list_employee' => ['required']
        ],
        [
            'required' => 'chưa nhập :attribute!',
            'max' => ':attribute phải bé hơn hoặc bằng :max ký tự!',
            'min' => ':attribute phải lớn hơn hoặc bằng :min ký tự!',
            'email' => ':attribute không hợp lệ!',
            'unique' => ':attribute đã được sử dụng!',
            'digits_between' => ':attribute phải từ :min đến :max!',
            'before' => 'Yêu cầu từ 18 tuổi trở lên',
            'identify_card' =>  ':attribute phải là kiểu số!',
            'end_time.after' => ':attribute phải sau thời gian bắt đầu!',
            'vaccination_date.after' => ':attribute phải sau ngày '.date('d/m/Y', strtotime('-1 days')),
            'start_time.after' => ':attribute phải sau giờ: '.date('H:i:s')
        ],
        [
            'vaccination_date' => 'ngày tiêm',
            'start_time' => 'giờ bắt đầu',
            'end_time' => 'giờ kết thúc',
            'vaccine_id' => 'vaccine',
            'list_employee' => 'danh sách nhân viên'
        ]
        );
    }
    public function prepare(Request $request) {
        $employees = $this->findImmunizationUnit()->employees;
        $data = $request->all();
        $this->validatorForPrepare($data)->validate();
        $vaccination_date = $data['vaccination_date'];
        $start_time = $data['start_time'];
        $end_time = $data['end_time'];
        $vaccine = $data['vaccine'];
        // $schedules = Schedule::where('vaccination_date', $data['vaccination_date'])->where('status', '!=', -2)->get();
        // $schedules =  $schedules->whereBetween('start_time', [$data['start_time'],$data['end_time']])
        //     ->orWhereBetween('end_time', [$data['start_time'], $data['end_time']]);
        $sches = Schedule::where('vaccination_date', $data['vaccination_date'])
        ->where('status', '!=', -2)
        // ->where(function ($query) use ($data) {
        //     $query->whereBetween('start_time', [$data['start_time'], $data['end_time']])
        //     ->orWhereBetween('end_time', [$data['start_time'], $data['end_time']]);
        // })
        ->get();
            // ->orWhere(function($query) use ($data) {
            //     $query->where('end_time', '<', $data['end_time'])
            //           ->where('start_time', '>', $data['end_time']);
            // })
        $schedules = [];
        foreach($sches as $sche) {
            if(($data['start_time'] >= $sche->start_time && $data['start_time'] <= $sche->end_time) || 
                ($data['end_time'] >= $sche->start_time && $data['end_time'] <= $sche->end_time) ||
                ($sche->start_time >= $data['start_time'] && $sche->start_time <= $data['end_time']) ||
                ($sche->end_time >= $data['start_time'] && $sche->end_time <= $data['end_time'])
            ) {
                $schedules[] = $sche;
            }
        }
        // $schedules = $schedules->where('end_time', "<", $data['end_time'])
        //                         ->where('start_time', ">", $data['end_time']);
        // return $schedules;
        $emIds = collect();
        foreach($schedules as $schedule) {
            $emIds->push(Group::where('schedule_id', $schedule->id)->pluck('employee_id')); // not use get because get will return o object
        }
        
        $employees = $employees->whereNotIn('id', $emIds->flatten()->toArray());
        return view('manager.schedule.create2', compact('vaccine', 'start_time', 'end_time', 'vaccine', 'vaccination_date', 'employees'));
    }
        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function prepareUpdate(Request $request, $id) {
        $schedule_id = $id;
        $employees = $this->findImmunizationUnit()->employees;
        $data = $request->all();
        $this->validatorForPrepare($data)->validate();
        $vaccination_date = $data['vaccination_date'];
        $start_time = $data['start_time'];
        $end_time = $data['end_time'];
        $vaccine = $data['vaccine'];
        // $schedules = Schedule::whereNotIn('id', [$id])->where('vaccination_date', $data['vaccination_date'])
        //     ->whereBetween('start_time', [$data['start_time'],$data['end_time']])
        //     ->whereBetween('end_time', [$data['start_time'], $data['end_time']])->where('status', '!=', -2)->get();

        $sches = Schedule::whereNotIn('id', [$id])->where('vaccination_date', $data['vaccination_date'])
        ->where('status', '!=', -2)
        ->get();  
        $schedules = [];
        foreach($sches as $sche) {
            if(($data['start_time'] >= $sche->start_time && $data['start_time'] <= $sche->end_time) || 
                ($data['end_time'] >= $sche->start_time && $data['end_time'] <= $sche->end_time) ||
                ($sche->start_time >= $data['start_time'] && $sche->start_time <= $data['end_time']) ||
                ($sche->end_time >= $data['start_time'] && $sche->end_time <= $data['end_time'])
            ) {
                $schedules[] = $sche;
            }
        }
        $emIds = collect();
        foreach($schedules as $schedule) {
            $emIds->push(Group::where('schedule_id', $schedule->id)->pluck('employee_id'));
        }
        $schedule2 = Schedule::find($id);
        $selectedGroups = $schedule2->groups;
        $selectedEmployeeIds = [];
       
        foreach($selectedGroups as $selectedGroup){
            $selectedEmployeeIds[] = $selectedGroup->employee->id;
        }
        $employees = $employees->whereNotIn('id', $emIds->flatten()->toArray());
        return view('manager.schedule.edit2', compact('vaccine', 'start_time', 'end_time', 'vaccine', 'vaccination_date', 'selectedEmployeeIds', 'employees', 'schedule_id'));
        // return "yessss";
    }
}
