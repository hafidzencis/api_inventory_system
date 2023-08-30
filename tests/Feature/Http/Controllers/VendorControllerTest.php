<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Nette\Utils\Json;
use Tests\TestCase;

class VendorControllerTest extends TestCase
{
    use WithFaker;


    public function test_add_vendor_success(){
        $vendor = [
            'vendor_name' => $this->faker->name(),
            'contact' => $this->faker->numerify('##########'),
            'email' => $this->faker->email()
        ];

        $this->json('POST','api/vendor',$vendor)
        ->assertStatus(200)
        ->assertJson([
            "code" => 200,
            "status" => "OK"
        ]);
    }

    public function test_failed_required_add_vendor(){
        $vendor = [
            'contact' => $this->faker->numerify('##########'),
            'email' => $this->faker->email()
        ];

        $this->json('POST','api/vendor',$vendor)
        ->assertStatus(400)
        ->assertJson([
            "code" => 400,
            "status" => "BAD_REQUEST"
        ]);
    }

    public function test_success_vendor_by_id(){
        $vendor = Vendor::create(
            [
                'vendor_name' => $this->faker->name(),
                'contact' => $this->faker->numerify('##########'),
                'email' => $this->faker->email()
            ]
        );

        $this->json('GET','api/vendor/'.$vendor->id)
        ->assertStatus(200)
        ->assertJson([
            "code" => 200,
            "status" => "OK"
        ]);
    }

    public function test_success_get_all_vendor(){
        $this->json('GET','api/vendor')
        ->assertStatus(200)
        ->assertJson([
            "code" => 200,
            "status" => "OK"
        ]);
    }

    public function test_failed_required_vendor_by_id(){
        $this->json('GET','api/vendor/0')
        ->assertStatus(404)
        ->assertJson([
            "code" => 404,
            "status" => "NOT_FOUND"
        ]);
    }

    public function test_success_update_vendor(){
        $vendor = Vendor::create([
            'vendor_name' => $this->faker->name(),
            'contact' => $this->faker->numerify('###########'),
            'email' => $this->faker->email()
        ]);

        $update = [
            'vendor_name' => "Jokotwitwi",
            'contact' => $this->faker->numerify('###########'),
            'email' => $this->faker->email()
        ];

        $this->json('PUT','api/vendor/'. $vendor->id,$update)
            ->assertStatus(200)
            ->assertJson([
                "code" => 200,
                "status" => "OK"
            ]);
    }

    public function test_failed_required_update_vendor(){
        $vendor = Vendor::create([
            'vendor_name' => $this->faker->name(),
            'contact' => $this->faker->numerify('##########'),
            'email' => $this->faker->email()
        ]);

        $update = [
            'vendor_name' => $this->faker->name(),
            'contact' => $this->faker->numerify('####'),
            'email' => $this->faker->name()
        ];

        $this->json('PUT','api/vendor/'.$vendor->id,$update)
            ->assertStatus(400)
            ->assertJson([
                "code" => 400,
                "status" => "BAD_REQUEST"
            ]);
    }

    public function test_failed_user_not_found_vendor_name(){
        $this->json('PUT','api/vendor/0')
        ->assertStatus(404)
        ->assertJson([
            "code" => 404,
            "status" => "NOT_FOUND"
        ]);
    }

    public function test_success_delete_vendor(){
        $vendor = Vendor::create([
            'vendor_name' => $this->faker->name(),
            'contact' => $this->faker->numerify('###########'),
            'email' => $this->faker->email()
        ]);

        $this->json('DELETE','api/vendor/'.$vendor->id)
            ->assertStatus(200)
            ->assertJson([
                "code" => 200,
                "status" => "OK"
            ]);
    }

    public function test_failed_not_found_id_delete_vendor(){
        $this->json('DELETE','api/vendor/0')
        ->assertStatus(404)
        ->assertJson([
            "code" => 404,
            "status" => "NOT_FOUND"
        ]);
    }
}
