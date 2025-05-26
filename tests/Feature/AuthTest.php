<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;


class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear el cliente personal de Passport
        $this->artisan('passport:client', [
            '--personal' => true,
            '--name' => 'Testing Client',
            '--provider' => 'users'
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_login(){

        $this->withoutExceptionHandling();
        
        #teniendo
        $user = User::factory()->create([
            'name'=>'Manolita',
            'email'=>'info@info.com',
            'password'=>bcrypt('123456')
        ]);
        
        #haciendo
        $response = $this->post(route('api.login'),[
            'email'=>'info@info.com',
            'password'=>'123456'
        ]);

        #esperando
        $response->assertStatus(200);
        $this->assertArrayHasKey('access_token', $response->json());
    }

    public function test_register(){
                
        $this->withoutExceptionHandling();

        $response = $this->post(route('api.register'), [
            'name'=> 'Manolita',
            'email' => 'info@info.com',
            'role' => User::ADMINISTRADOR,
            'password' => '123456'
        ]);

        $response->assertStatus(201);
        $this->assertArrayHasKey('access_token', $response->json());
    }
}
   