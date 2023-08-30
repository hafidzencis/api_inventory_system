<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Resources\Vendor;
use App\Models\Inventory;
use App\Models\Storage_Unit;
use App\Models\Vendor as ModelsVendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InventoryControllerTest extends TestCase
{
    use WithFaker;

    public function test_success_add_inventory(){

        $res_vendor = ModelsVendor::create([
            'vendor_name' => $this->faker->name(),
            'contact' => $this->faker->numerify('##########'),
            'email' => $this->faker->email(),
        ]);

        $res_storage_unit = Storage_Unit::create([
            'vendor_id' => $res_vendor->id ,
            'warehouse_name' =>$this->faker->name(),
            'location' => $this->faker->name()
        ]);

        $res = [
            "storage_unit_id" => $res_storage_unit->id,
            "item_name" => $this->faker->name(),
            "item_type" => $this->faker->name(),
            "quantity"  => 20,
            "barcode" => $this->faker->name()
        ];

        $this->json('POST','api/inventory',$res)
            ->assertStatus(200)
            ->assertJson([
                "code" => 200,
                "status" => "OK"
            ]);
    }

    public function test_failed_required_add_inventory(){
        $res_vendor = ModelsVendor::create([
            'vendor_name' => $this->faker->name(),
            'contact' => $this->faker->numerify('##########'),
            'email' => $this->faker->email(),
        ]);

        $res_storage_unit = Storage_Unit::create([
            'vendor_id' => $res_vendor->id ,
            'warehouse_name' =>$this->faker->name(),
            'location' => $this->faker->name()
        ]);

        $res = [
            "storage_unit_id" => $res_storage_unit->id,
            "item_name" => $this->faker->name(),
            "item_type" => $this->faker->name(),
            "quantity"  => 20,
        ];

        $this->json('POST','api/inventory',$res)
            ->assertStatus(400)
            ->assertJson([
                "code" => 400,
                "status" => "BAD_REQUEST"
            ]);
    }

    public function test_failed_not_found_id_Storageunit_create_inventory(){
            $res = [
                "storage_unit_id" => 0,
                "item_name" => $this->faker->name(),
                "item_type" => $this->faker->name(),
                "quantity"  => 20,
                "barcode" => $this->faker->name()
            ];

            $this->json('POST','api/inventory',$res)
                ->assertStatus(404)
                ->assertJson([
                    "code" => 404,
                    "status" => "NOT_FOUND"
                ]);
    }

    public function test_success_get_inventory_by_id(){
        $res_vendor = ModelsVendor::create([
            'vendor_name' => $this->faker->name(),
            'contact' => $this->faker->numerify('##########'),
            'email' => $this->faker->email(),
        ]);

        $res_storage_unit = Storage_Unit::create([
            'vendor_id' => $res_vendor->id ,
            'warehouse_name' =>$this->faker->name(),
            'location' => $this->faker->name()
        ]);

        $res = Inventory::create([
            "storage_unit_id" => $res_storage_unit->id,
            "item_name" => $this->faker->name(),
            "item_type" => $this->faker->name(),
            "quantity"  => 20,
            "barcode" => $this->faker->name()
        ]);

        $this->json('GET','api/inventory/'.$res->id)
            ->assertStatus(200)
            ->assertJson([
                "code" => 200,
                "status" => "OK"
            ]);
    }

    public function test_failed_id_inventory_not_found(){

        $this->json('GET','api/inventory/0')
        ->assertStatus(404)
        ->assertJson([
            "code" => 404,
            "status" => "NOT_FOUND"
        ]);
    }

    public function test_success_get_all(){
        $this->json('GET','api/inventory')
        ->assertStatus(200)
        ->assertJson([
            "code" => 200,
            "status" => "OK"
        ]);
    }
    
    public function test_success_update_inventory(){

        $res_vendor = ModelsVendor::create([
            'vendor_name' => $this->faker->name(),
            'contact' => $this->faker->numerify('##########'),
            'email' => $this->faker->email(),
        ]);

        $res_storage_unit = Storage_Unit::create([
            'vendor_id' => $res_vendor->id ,
            'warehouse_name' =>$this->faker->name(),
            'location' => $this->faker->name()
        ]);

        $res = Inventory::create([
            "storage_unit_id" => $res_storage_unit->id,
            "item_name" => $this->faker->name(),
            "item_type" => $this->faker->name(),
            "quantity"  => 20,
            "barcode" => $this->faker->name()
        ]);

        $update = [
            "storage_unit_id" => $res_storage_unit->id,
            "item_name" => $this->faker->name(),
            "item_type" => $this->faker->name(),
            "quantity"  => 19,
            "barcode" => $this->faker->name()
        ];

        $this->json('PUT','api/inventory/'.$res->id,$update)
            ->assertStatus(200)
            ->assertJson([
                "code" => 200,
                "status" => "OK"
            ]);
    }

    public function test_failed_required_update_inventory(){

        $res_vendor = ModelsVendor::create([
            'vendor_name' => $this->faker->name(),
            'contact' => $this->faker->numerify('##########'),
            'email' => $this->faker->email(),
        ]);

        $res_storage_unit = Storage_Unit::create([
            'vendor_id' => $res_vendor->id ,
            'warehouse_name' =>$this->faker->name(),
            'location' => $this->faker->name()
        ]);

        $res = Inventory::create([
            "storage_unit_id" => $res_storage_unit->id,
            "item_name" => $this->faker->name(),
            "item_type" => $this->faker->name(),
            "quantity"  => 20,
            "barcode" => $this->faker->name()
        ]);

        $update = [
            "storage_unit_id" => $res_storage_unit->id,
            "item_name" => $this->faker->name(),
            "item_type" => $this->faker->name(),
            "quantity"  => "gencock",
            "barcode" => $this->faker->name()
        ];

        $this->json('PUT','api/inventory/'.$res->id,$update)
            ->assertStatus(400)
            ->assertJson([
                "code" => 400,
                "status" => "BAD_REQUEST"
            ]);
    }

    // public function test_failed_id_null_update_inventory(){

    //     $this->json('PUT','api/inventory/0')
    //         ->assertStatus(404)
    //         ->assertJson([
    //             "code" => 404,
    //             "status" => "NOT_FOUND"
    //         ]);
    // }

    public function test_success_delete_inventory(){
        $res_vendor = ModelsVendor::create([
            'vendor_name' => $this->faker->name(),
            'contact' => $this->faker->numerify('##########'),
            'email' => $this->faker->email(),
        ]);

        $res_storage_unit = Storage_Unit::create([
            'vendor_id' => $res_vendor->id ,
            'warehouse_name' =>$this->faker->name(),
            'location' => $this->faker->name()
        ]);

        $res = Inventory::create([
            "storage_unit_id" => $res_storage_unit->id,
            "item_name" => $this->faker->name(),
            "item_type" => $this->faker->name(),
            "quantity"  => 20,
            "barcode" => $this->faker->name()
        ]);

        $this->json('DELETE','api/inventory/'.$res->id)
        ->assertStatus(200)
        ->assertJson([
            "code" => 200,
            "status" => "OK"
        ]);
    }

    
    public function test_failed_id_notfound_delete_inventory(){

        $this->json('DELETE','api/inventory/0')
        ->assertStatus(404)
        ->assertJson([
            "code" => 404,
            "status" => "NOT_FOUND"
        ]);
    }


}
