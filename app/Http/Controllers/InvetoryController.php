<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Models\Inventory;
use App\Models\Storage_Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class InvetoryController extends BaseController
{
    public function createInventory(Request $request){
        $input = $request->all();

        $validator = Validator::make($input,[
            "storage_unit_id" => 'required',
            "item_name" => 'required',
            "item_type" => 'required',
            "quantity"  => 'required|numeric',
            "barcode" => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendResponseBadRequest($validator->errors());
        }

        $storage_unit = Storage_Unit::with(['vendors'])->find($request->storage_unit_id);


        if ( is_null($storage_unit) ){

            return $this->sendResponseNotFound("Storage unit not found");
        }


        $inventory = new Inventory();
        $inventory['storage_unit_id'] = $request->storage_unit_id;
        $inventory['item_name'] = $request->item_name;
        $inventory['item_type'] = $request->item_type;
        $inventory['quantity'] = $request->quantity;
        $inventory['barcode'] = $request->barcode;

        $inventory->save();

        $res_vendor = [
            'vendor_id' => $storage_unit->vendors->id,
            'vendor_name' => $storage_unit->vendors->vendor_name,
            'contact' => $storage_unit->vendors->contact,
            'email' => $storage_unit->vendors->email
        ];

        $res_storage_unit = [
            'storage_unit_id' =>$storage_unit->id,
            'vendor' => $res_vendor ,
            'warehouse_name' => $storage_unit->warehouse_name,
            'location' => $storage_unit->location
        ];

        $res =[
            "id" => $inventory->id,
            "storage_unit" => $res_storage_unit,
            "item_name" => $inventory->item_name,
            "item_type" => $inventory->item_type,
            "quantity"  => $inventory->quantity,
            "barcode" => $inventory->barcode
        ];

        return $this->sendResponseSuccess($res);
    }

    public function getInventoryById($id){
        $inventory = Inventory::find($id);

        if (is_null($inventory)) {
            return $this->sendResponseNotFound("Inventory not found");
        }

        $storage_unit = Storage_Unit::with(['vendors'])->find($inventory->id);

        $res_vendor = [
            'vendor_id' => $storage_unit->vendors->id,
            'vendor_name' => $storage_unit->vendors->vendor_name,
            'contact' => $storage_unit->vendors->contact,
            'email' => $storage_unit->vendors->email
        ];

        $res_storage_unit = [
            'storage_unit_id' =>$storage_unit->id,
            'vendor' => $res_vendor ,
            'warehouse_name' => $storage_unit->warehouse_name,
            'location' => $storage_unit->location
        ];

        $res =[
            "id" => $inventory->id,
            "storage_unit" => $res_storage_unit,
            "item_name" => $inventory->item_name,
            "item_type" => $inventory->item_type,
            "quantity"  => $inventory->quantity,
            "barcode" => $inventory->barcode
        ];

        return $this->sendResponseSuccess($res);

    }

    public function getAllInventory(){
        $inventory = Inventory::all();

        $storage_unit = Storage_Unit::with(['vendors'])->get();

        $last_result = [];

        foreach ($inventory as $item ) {

            foreach ($storage_unit as $item_su ) {
                if ( $item->storage_unit_id == $item_su->id) {
                    // return response()->json($item_su->id);
                    $res_vendor = [
                        'vendor_id' => $item_su->vendors->id,
                        'vendor_name' => $item_su->vendors->vendor_name,
                        'contact' => $item_su->vendors->contact,
                        'email' => $item_su->vendors->email
                    ];
            
                    $res_storage_unit = [
                        'storage_unit_id' =>$item_su->id,
                        'vendor' => $res_vendor ,
                        'warehouse_name' => $item_su->warehouse_name,
                        'location' => $item_su->location
                    ];
            
                    $res = [
                        "id" => $item->id,
                        "storage_unit" => $res_storage_unit,
                        "item_name" => $item->item_name,
                        "item_type" => $item->item_type,
                        "quantity"  => $item->quantity,
                        "barcode" => $item->barcode
                    ];
                    // return response()->json($res);
                    array_push($last_result,$res);
                }
            }
        }

        return $this->sendResponseSuccess($last_result);
    }

    public function updateInventory(Request $request,$id){
        $validator = Validator::make($request->all(),[
            "storage_unit_id" => 'numeric',
            "item_name" => 'string',
            "item_type" => 'string',
            "quantity"  => 'numeric',
            "barcode" => 'string'
        ]);

        if ($validator->fails()) {
            return $this->sendResponseBadRequest($validator->errors());
        }

        $inventory = Inventory::find($id);

        if ( is_null($inventory)) {
            return $this->sendResponseNotFound("Not Found");
        }

        $inventory['storage_unit_id'] = $request->storage_unit_id;
        $inventory['item_name'] = $request->item_name;
        $inventory['item_type'] = $request->item_type;
        $inventory['quantity'] = $request->quantity;
        $inventory['barcode'] = $request->barcode;

        $inventory->save();

        $storage_unit = Storage_Unit::with(['vendors'])->find($inventory->storage_unit_id);

        $res_vendor = [
            'vendor_id' => $storage_unit->vendors->id,
            'vendor_name' => $storage_unit->vendors->vendor_name,
            'contact' => $storage_unit->vendors->contact,
            'email' => $storage_unit->vendors->email
        ];

        $res_storage_unit = [
            'storage_unit_id' =>$storage_unit->id,
            'vendor' => $res_vendor ,
            'warehouse_name' => $storage_unit->warehouse_name,
            'location' => $storage_unit->location
        ];

        $res =[
            "id" => $inventory->id,
            "storage_unit" => $res_storage_unit,
            "item_name" => $inventory->item_name,
            "item_type" => $inventory->item_type,
            "quantity"  => $inventory->quantity,
            "barcode" => $inventory->barcode
        ];

        return $this->sendResponseSuccess($res);
    }

    public function deleteInventory($id){
        $inventory = Inventory::find($id);

        if (is_null($inventory)) {
            return $this->sendResponseNotFound("Inventory not found");
        }

        $inventory->delete();

        return $this->sendResponseSuccess("Succefull Delete Inventori");

    }
}
