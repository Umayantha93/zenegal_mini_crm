<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    //
    public function index(){
        $data = Company::all();

        return view('employee.index',  ['data'=>$data]);
    }

    public function storeemployee(Request $request)
    {
    
        $validator = Validator::make($request->all(),[
            'first_name' => 'required|max:191',
            'last_name' => 'required|max:191',

        ]);

        if($validator->fails())
        {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        }
        else{
            $employee = new Employee;
            $employee->first_name = $request->input('first_name');
            $employee->last_name = $request->input('last_name');
            $employee->company = $request->input('company');
            $employee->email = $request->input('email');
            $employee->phone = $request->input('phone');
            $employee->save();

            return response()->json([
                'status' => 200,
                'message' => "Employee Added Successfully"
            ]);
        }
    }
}
