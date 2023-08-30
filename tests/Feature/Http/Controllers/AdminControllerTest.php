<?php

namespace Tests\Feature\Http\Controllers;


use App\Models\Admin;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;



class AdminControllerTest extends TestCase
{
    use WithFaker;

    public function test_add_admin_success(){

        $this->postJson('api/admin', [
            'name' => $this->faker->name(),
            'contact' => $this->faker->numerify('##########'),
            'email'=> $this->faker->email()
        ])->assertStatus(200);


    }

    public function test_add_failed_required_field(){
        $this->postJson('api/admin', [
            'name' => $this->faker->name(),
            'contact' => $this->faker->numerify('##########')
        ])
        ->assertStatus(400)
        ->assertJson([
            "code" => 400,
            "status" => "BAD_REQUEST"
        ]);
    }

    public function test_get_admin_by_id_success(){

        $admin = Admin::create([
            'name' => $this->faker->name(),
            'contact' => $this->faker->numerify('##########'),
            'email' => $this->faker->email()
        ]);
        $this->json('GET','api/admin/'.$admin->id)
            ->assertStatus(200)
            ->assertJson([
                "code" => 200,
                "status" => "OK"
            ]);
    }

    public function test_get_admin_by_id_null_failed(){
        $this->json('GET','api/admin/0')
        ->assertStatus(404)
        ->assertJson([
            "code" => 404,
            "status" => "NOT_FOUND"
        ]);
    }

    public function test_success_get_all_admin(){
        $this->json('GET','api/admin')
            ->assertStatus(200)
            ->assertJson([
                "code" => 200,
                "status" => "OK"
            ]);
    }

    public function test_update_admin_success(){
        $admin = Admin::create([
            'name' => $this->faker->name(),
            'contact' => $this->faker->numerify('##########'),
            'email' => $this->faker->email()
        ]);

        $payload = [
            'name' => "Jaka Wodidi",
            'contact' => "0891234567",
            'email' => $admin->email
        ];

        $this->json('PUT','api/admin/'.$admin->id,$payload)
        ->assertStatus(200)
        ->assertJson([
            "code" => 200,
            "status" => "OK"
        ]);
    }
    
    public function test_failed_id_null_update_admin(){
        $this->json('PUT','api/admin/0')
        ->assertStatus(404)
        ->assertJson([
            "code" => 404,
            "status" => "NOT_FOUND"
        ]);
    }

    public function test_failed_required_update_field(){
        $admin = Admin::create([
            'name' => $this->faker->name(),
            'contact' => $this->faker->numerify('##########'),
            'email' => $this->faker->email()
        ]);

        $payload = [
            'name' => "Jaka Wodidi",
            'contact' => "0891234567",
        ];

        $this->json('PUT','api/admin/'.$admin->id,$payload)
        ->assertStatus(400)
        ->assertJson([
            "code" => 400,
            "status" => "BAD_REQUEST"
        ]);
    }

    public function test_success_delete_admin(){
        $admin = Admin::create([
            'name' => $this->faker->name(),
            'contact' => $this->faker->numerify('##########'),
            'email' => $this->faker->email()
        ]);

        $this->json('DELETE','api/admin/'.$admin->id)
        ->assertStatus(200)
                ->assertJson([
                    "code" => 200,
                    "status" => "OK"
                ]);

                
    }

    public function test_delete_failed_id_null(){
        $this->json('DELETE','api/admin/0')
        ->assertStatus(404)
        ->assertJson([
            "code" => 404,
            "status" => "NOT_FOUND"
        ]);
    }

}

//CARA MENJALANKAN PHPUNITTEST
// ./vendor/bin/phpunit tests/Feature/Http/Controllers/AdminControllerTest.php