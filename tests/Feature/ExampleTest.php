<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanCreate()
    {
        // Crear un usuario de prueba
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
    
        //POST de inicio de sesión
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);
    
        // Verifica que el user se fue a welcome o /
        $response->assertRedirect('/');
    
        // User autenticado
        $this->assertAuthenticated();
    
        // Hacemos el get para la vista
        $createRestaurantViewResponse = $this->get('/restaurants/create');

        // La vista se carga bien
        $createRestaurantViewResponse->assertStatus(200);

        // Crear el restaurant
        $restaurantData = [
            'name' => 'Nombre del restaurante',
            'address' => 'Dirección del restaurante',
            'latitude' => 12.3651200,
            'longitude' => 12.3651200,
            'description' => 'Descripción del restaurante',
            'image' => UploadedFile::fake()->image('restaurant.jpg'),
        ];
    
        $createRestaurantResponse = $this->post('/restaurants', $restaurantData);
       
        $createRestaurantResponse->assertRedirect('/misRestaurantes');
    }
}
