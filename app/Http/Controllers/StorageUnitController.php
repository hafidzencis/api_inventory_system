<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\StorageUnit as ResourceStorageUnit;
use App\Models\Vendor;
use App\Models\Storage_Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as Validating;

class StorageUnitController extends BaseController
{
    public function createStorageUnit(Request $request){
        $input = $request->all();

        $validator = Validating::make($input,[
            'warehouse_name' => 'required',
            'location' => 'required',
            'vendor_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendResponseBadRequest($validator->errors());
        }

        $vendor_name = Vendor::find($request->vendor_id);

        if ( is_null($vendor_name)) {
            return $this->sendResponseNotFound('Vendor not found');
        }

        $storageUnit = new Storage_Unit();
        $storageUnit['warehouse_name'] = $request->warehouse_name;
        $storageUnit['location'] = $request->location;
        $storageUnit['vendor_id'] = $vendor_name->id;

        $storageUnit->save();
        
        $res_vendor = [
            'vendor_id' => $vendor_name->id,
            'vendor_name' => $vendor_name->vendor_name,
            'contact' => $vendor_name->contact,
            'email' => $vendor_name->email
        ];

        $res = [
            'id' => $storageUnit->id,
            'vendor' => $res_vendor ,
            'warehouse_name' => $storageUnit->warehouse_name,
            'location' => $storageUnit->location
        ];

        // return response()->json($storageUnit);
        return $this->sendResponseSuccess($res);
    }

    public function getStorageUnitById($id){
        $storage_unit = Storage_Unit::with(['vendors'])->find($id);

        if ( is_null($storage_unit)) {
            return $this->sendResponseNotFound('Storage Unit not found');
        }
        $res_vendor = [
            'vendor_id' => $storage_unit->vendors->id,
            'vendor_name' => $storage_unit->vendors->vendor_name,
            'contact' => $storage_unit->vendors->contact,
            'email' => $storage_unit->vendors->email
        ];

        $res = [
            'id' =>$storage_unit->id,
            'vendor' => $res_vendor ,
            'warehouse_name' => $storage_unit->warehouse_name,
            'location' => $storage_unit->location
        ];
        //return response()->json($storage_unit->vendors);

        return $this->sendResponseSuccess($res);
    }


    public function getAllStorageUnit(){
        $storage_unit = Storage_Unit::with(['vendors'])->get();

        if (is_null($storage_unit)) {
            return $this->sendResponseNotFound('Storage Unit not found');
        }

        $all_storage_unit = [];

        foreach ($storage_unit as $items) {
            $res_vendor = [
                'vendor_id' => $items->vendors->id,
                'vendor_name' => $items->vendors->vendor_name,
                'contact' => $items->vendors->contact,
                'email' => $items->vendors->email
            ];
    
            $res = [
                'id' =>$items->id,
                'vendor' => $res_vendor ,
                'warehouse_name' => $items->warehouse_name,
                'location' => $items->location
            ];

            array_push($all_storage_unit,$res);
        }

        return $this->sendResponseSuccess($all_storage_unit);
    }

    public function updateStorageUnit(Request $request, $id){
        $storage_unit = Storage_Unit::find($id);

        if (is_null($storage_unit)){
            return $this->sendResponseNotFound("Storage Unit not fouund");
        }

        $validator = Validating::make($request->all(),[
            'warehouse_name' => 'required',
            'location' => 'required',
            'vendor_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendResponseBadRequest($validator->errors());
        }

        $storage_unit['warehouse_name'] = $request->warehouse_name;
        $storage_unit['location'] = $request->location;
        $storage_unit['vendor_id'] = $request->vendor_id;

        $storage_unit->save();

        $res_vendor = [
            'vendor_id' => $storage_unit->vendors->id,
            'vendor_name' => $storage_unit->vendors->vendor_name,
            'contact' => $storage_unit->vendors->contact,
            'email' => $storage_unit->vendors->email
        ];

        $res = [
            'id' =>$storage_unit->id,
            'vendor' => $res_vendor ,
            'warehouse_name' => $storage_unit->warehouse_name,
            'location' => $storage_unit->location
        ];

        return $this->sendResponseSuccess($res);

    }

    public function deleteStorageUnit($id){
        $storage_unit = Storage_Unit::find($id);

        if (is_null($storage_unit)){
            return $this->sendResponseNotFound('Storage unit not found');
        }

        $storage_unit->delete();

        return $this->sendResponseSuccess("Success delete storage_unit");
    }
}
