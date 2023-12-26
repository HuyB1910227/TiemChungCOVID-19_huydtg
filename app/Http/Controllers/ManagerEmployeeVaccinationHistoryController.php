<?php

namespace App\Http\Controllers;

use App\VaccinationHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ImmunizationUnit;
class ManagerEmployeeVaccinationHistoryController extends Controller
{
    
    public function show($id) {
        $employees = [];
        $vaccinationHistory = VaccinationHistory::find($id);
        $groups = $vaccinationHistory->schedule->groups;
        foreach($groups as $group) {
            $employees[] = $group->employee;
        }
        return view('manager-employee.vaccination-history.show', compact('vaccinationHistory', 'employees'));
    }
    
}
