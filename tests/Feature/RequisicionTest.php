<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Carbon;
use App\Models\requisicion\Requisicion;

class RequisicionTest extends TestCase
{
    /** @test */
    // public function displays_the_requisicion_form()
    // {
    //     $user = User::factory()->create();
    //     $title = 'My test post';
    //     $response = $this->actingAs($user)
    //     ->withSession(['foo' => 'bar'])
    //     ->get(route('requisicion.create'));
    //     $response->assertStatus(200);
    // }

    /** @test */

    public function display_store_requisicion(){
        //$user = User::factory()->create();
        $user = User::where('email','usuarioprueba@email.com') -> first();
        $this->faker = \Faker\Factory::create();

        $data = [
            'concepto' => $this->faker->sentence(),
            'partida_presupuestal' => $this->faker->sentence(),
            'fechaRequisicion' => '2021-03-25'
        ];

        $this->actingAs($user)
        ->withSession(['foo' => 'bar'])
        ->withHeaders(['Accept' => 'application/json'])
        ->post(route('requisicion.store'), $data)
            ->dump()
            ->assertStatus(201)
            ->assertJson(['data' => $data]);
    
    }
}
