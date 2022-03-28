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

    public function fetchcompanies()
    {
        $company = Company::paginate(5)->all();
        return response()->json([
            'company' => $company,
        ]);
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

    public function getcompany($id)
    {
        $company = Company::find($id);
        if($company)
        {
            return response()->json([
                'status' => 200,
                'company' => $company
            ]);
        }
        else
        {
            return response()->json([
                'status' => 404,
                'message' => 'Company Not Found'
            ]);
        }

    }

    public function updatecompany(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:191',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        }

        else{

            $company = Company::find($id);
            if($company)
            {
                $company->name = $request->input('name');
                $company->email = $request->input('email');
                $company->website = $request->input('website');

                if($request->hasFile('logo'))
                {
                    $path = 'storage/app/public/'.$company->logo;
                    if(File::exists($path))
                    {
                        File::delete($path);
                    }
                    $file = $request->file('logo');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time().'.'.$extension;
                    $file->move('storage/app/public/', $filename);
                    $company->logo = $filename;
                }
                $company->save();
                return response()->json([
                    'status' => 200,
                    'message' => "Company Updated Successfully"
                ]);
            }
            else
            {
                return response()->json([
                    'status' => 404,
                    'message' => $request
                ]);
            }
        }
    }
    public function destroy($id)
    {
        $company = Company::find($id);
        if($company)
        {
            $path = 'storage/app/public/'.$company->logo;
            if(File::exists($path))
            {
                File::delete($path);
            } 
            $company->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Company Deleted Successfully'
            ]);
        }
        else
        {
            return response()->json([
                'status' => 404,
                'message' => 'Company Not Found'
            ]);
        }
    }

}
