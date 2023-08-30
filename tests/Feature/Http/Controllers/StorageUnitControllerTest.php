<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Resources\StorageUnit;
use App\Http\Resources\Vendor;
use App\Models\Storage_Unit;
use App\Models\Vendor as ModelsVendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StorageUnitControllerTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_success_add_storage_unit(){
        $vendor = ModelsVendor::create ([
            'vendor_name' => $this->faker->name(),
            'contact' => $this->faker->numerify('##########'),
            'email' => $this->faker->email()
        ]);

        $add_storage_unit = [
            'vendor_id' => $vendor->id ,
            'warehouse_name' => $this->faker->name(),
            'location' => $this->faker->name()
        ];


        $this->json('POST','api/storageunit',$add_storage_unit)
        ->assertStatus(200)
        ->assertJson([
            "code" => 200,
            "status" => "OK"
        ]);
    }

    public function test_failed_not_found_vendor_storageunit(){
        $add_storage_unit = [
            'vendor_id' => 0 ,
            'warehouse_name' => $this->faker->name(),
            'location' => $this->faker->name()
        ];


        $this->json('POST','api/storageunit',$add_storage_unit)
        ->assertStatus(404)
        ->assertJson([
            "code" => 404,
            "status" => "NOT_FOUND"
        ]);
    }

    public function test_failed_not_required_storageunit(){
        $add_storage_unit = [
            'warehouse_name' => $this->faker->name(),
            'location' => $this->faker->name()
        ];


        $this->json('POST','api/storageunit',$add_storage_unit)
        ->assertStatus(400)
        ->assertJson([
            "code" => 400,
            "status" => "BAD_REQUEST"
        ]);
    }


    public function test_success_get_storage_unit_by_id(){
        $vendor = ModelsVendor::create ([
            'vendor_name' => $this->faker->name(),
            'contact' => $this->faker->numerify('##########'),
            'email' => $this->faker->email()
        ]);

        $add_storage_unit = Storage_Unit::create([
            'vendor_id' => $vendor->id ,
            'warehouse_name' => $this->faker->name(),
            'location' => $this->faker->name()
        ]);


        $this->json('GET','api/storageunit/'.$add_storage_unit->id)
        ->assertStatus(200)
        ->assertJson([
            "code" => 200,
            "status" => "OK"
        ]);
    }

    public function test_failed_not_found_id_storageunit(){

        $this->json('GET','api/storageunit/0')
        ->assertStatus(404)
        ->assertJson([
            "code" => 404,
            "status" => "NOT_FOUND"
        ]);
    }


    public function test_success_get_all_storageunit(){
        $this->json('GET','api/storageunit')
        ->assertStatus(200)
        ->assertJson([
            'code' => 200,
            'status' => "OK"
        ]);
    }

    public function test_success_update_storageunit(){
        $vendor = ModelsVendor::create ([
            'vendor_name' => $this->faker->name(),
            'contact' => $this->faker->numerify('##########'),
            'email' => $this->faker->email()
        ]);

        $add_storage_unit = Storage_Unit::create([
            'vendor_id' => $vendor->id ,
            'warehouse_name' => $this->faker->name(),
            'location' => $this->faker->name()
        ]);

        $update = [
            'vendor_id' => $vendor->id ,
            'warehouse_name' => "Probawa Sabionta",
            'location' => "Trisakti",
        ];

        $this->json('PUT','api/storageunit/'.$add_storage_unit->id,$update)
            ->assertStatus(200)
            ->assertJson([
                'code' => 200,
                'status' => "OK"
            ]);
    }

    public function test_failed_not_found_id_upadate_storageunit(){
        $this->json('GET','api/storageunit/0')
        ->assertStatus(404)
        ->assertJson([
            "code" => 404,
            "status" => "NOT_FOUND"
        ]);
    }

    public function test_failed_requird_update_storageunit(){
        $vendor = ModelsVendor::create ([
            'vendor_name' => $this->faker->name(),
            'contact' => $this->faker->numerify('##########'),
            'email' => $this->faker->email()
        ]);

        $add_storage_unit = Storage_Unit::create([
            'vendor_id' => $vendor->id ,
            'warehouse_name' => $this->faker->name(),
            'location' => $this->faker->name()
        ]);

        $update = [
            'warehouse_name' => "Probawa Sabionta",
            'location' => "Trisakti",
        ];

        $this->json('PUT','api/storageunit/'.$add_storage_unit->id,$update)
            ->assertStatus(400)
            ->assertJson([
                'code' => 400,
                'status' => "BAD_REQUEST"
            ]);
    }

    public function test_success_delete_storageunit(){
        $vendor = ModelsVendor::create ([
            'vendor_name' => $this->faker->name(),
            'contact' => $this->faker->numerify('##########'),
            'email' => $this->faker->email()
        ]);

        $add_storage_unit = Storage_Unit::create([
            'vendor_id' => $vendor->id ,
            'warehouse_name' => $this->faker->name(),
            'location' => $this->faker->name()
        ]);

        $this->json('DELETE','api/storageunit/'.$add_storage_unit->id)
            ->assertStatus(200)
            ->assertJson([
                'code' => 200,
                'status' => "OK"
            ]);
    }

    public function test_failed_not_found_id_delete_storageunit(){
        $this->json('DELETE','api/storageunit/0')
        ->assertStatus(404)
        ->assertJson([
            "code" => 404,
            "status" => "NOT_FOUND"
        ]);
    }



}
