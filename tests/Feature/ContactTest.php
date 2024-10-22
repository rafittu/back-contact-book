<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Contact;
use App\Models\Address;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_a_contact_with_valid_data()
    {
        $response = $this->postJson('/api/contacts', [
            'name' => 'John Doe',
            'phone' => '123456789',
            'email' => 'johndoe@example.com',
            'cep' => '01001000'
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'id', 'name', 'phone', 'email', 'address' => [
                         'id', 'cep', 'street', 'neighborhood', 'city', 'state'
                     ]
                 ]);

        $this->assertDatabaseHas('contacts', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com'
        ]);
    }
}
