<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\Admin as ResourcesAdmin;
use App\Models\Admin;
use Illuminate\Auth\Events\Validated;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class AdminController extends BaseController
{
    public function createAdmin(Request $request){
        $input = $request->all();
        
        $validator = FacadesValidator::make($input,[
            'name' => 'required',
            'contact' => 'required|numeric|min:8',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return $this->sendResponseBadRequest($validator->errors());
        }

        $admin = Admin::create($input);
        return $this->sendResponseSuccess(new ResourcesAdmin($admin));
        
    }

    public function getAdminById($id){
        $admin =  Admin::find($id);
        if ( is_null($admin)) {
            return $this->sendResponseNotFound(['Admin does not exist']);
        }

        return $this->sendResponseSuccess(new ResourcesAdmin($admin));

    }

    public function getAllAdmin(){
        $admin = Admin::all();
        if ( is_null($admin)){
            return $this->sendResponseNotFound('All Admin does not exist');
        }
        return $this->sendResponseSuccess(ResourcesAdmin::collection($admin));
    }

    public function updateAdmin(Request $request,$id){
        $admin = Admin::find($id);
        // return response()->json($admin);
        if (is_null($admin)) {
            return $this->sendResponseNotFound('Admin does not exist');
        }

        $validator = FacadesValidator::make($request->all(),[
            'name' => 'required',
            'contact' => 'required|numeric|min:8',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return $this->sendResponseBadRequest($validator->errors());
        }

        $admin['name'] = $request->name;
        $admin['contact'] = $request->contact;
        $admin['email'] = $request->email;
        $admin->save();

        return $this->sendResponseSuccess(new ResourcesAdmin($admin));
    }


    public function deleteAdmin($id){
        $admin = Admin::find($id);

        if (is_null($admin)) {
            return $this->sendResponseNotFound('Admin doesnot exist');
        }

        $admin->delete();
        return $this->sendResponseSuccess("Success delete");
    }
}
