<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Company;

class EmployeeController extends Controller
{
    //
    public function index(){
        $data = Company::all();

        return view('employee.index',  ['data'=>$data]);
    }
}
