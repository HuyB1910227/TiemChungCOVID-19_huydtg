<?php

namespace App\Http\Controllers;
use App\User;
use App\Role;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function showUsersByRole($id){
        return Role::find($id)->users;
    }
    public function showRolesByUser($id){
        return User::find($id)->roles->first()->name;
    }
}
