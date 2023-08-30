<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Models\Vendor;
use App\Http\Resources\Vendor as ResourcesVendor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\ErrorHandler\Collecting;

class VendorController extends BaseController
{
    public function createVendor(Request $request){
        $input = $request->all();

        $validator = Validator::make($input,[
            'vendor_name' => 'required',
            'contact' => 'required|numeric|min:8',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return $this->sendResponseBadRequest($validator->errors());
        }

        $vendor = Vendor::create($input);
        return $this->sendResponseSuccess(new ResourcesVendor($vendor));

    }

    public function getVendorById($id){
        $vendor = Vendor::find($id);

        if (is_null($vendor)) {
            return $this->sendResponseNotFound("Vendor does not exist");
        }

        return $this->sendResponseSuccess(new ResourcesVendor($vendor));
    }

    public function getAllVendor(){
        $vendor = Vendor::all();

        if (is_null($vendor)) {
            return $this->sendResponseNotFound("Vendor does not exist");
        }

        return $this->sendResponseSuccess(ResourcesVendor::collection($vendor));

    }

    public function updateVendor(Request $request,$id){
        $vendor = Vendor::find($id);

        if (is_null($vendor)) {
            return $this->sendResponseNotFound("Vendor does not exist");
        }

        $validator = Validator::make($request->all(),[
            'vendor_name' => 'required',
            'contact' => 'required|numeric|min:8',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return $this->sendResponseBadRequest($validator->errors());
        }

        $vendor['vendor_name'] = $request->vendor_name;
        $vendor['contact'] = $request->contact;
        $vendor['email'] = $request->email;
        $vendor->save();

        return $this->sendResponseSuccess(new ResourcesVendor($vendor));
        
    }

    public function deleteVendor($id){
        $vendor = Vendor::find($id);

        if (is_null($vendor)) {
            return $this->sendResponseNotFound("Vendor does not exist");
        }

        $vendor->delete();

        return $this->sendResponseSuccess("Vendor succesfully delete");

    }


}
