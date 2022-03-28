<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class CompanyController extends Controller
{
    //
    public function index(){
        return view('company.index');
    }

    public function storecompany(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:191',
            'logo' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        }
        else{
            $company = new Company;
            $company->name = $request->input('name');
            $company->email = $request->input('email');
            $company->website = $request->input('website');

            if($request->hasFile('logo'))
            {
                $path = 'storage/app/public/';
                $file = $request->file('logo');
                $extension = $file->getClientOriginalExtension();
                $filename = time() .'.'.$extension;
                $file->move('storage/app/public/', $filename);
                $company->logo = $filename;
            }
            $company->save();

            return response()->json([
                'status' => 200,
                'message' => "Company Inserted Successfully"
            ]);
        }
    }
}
