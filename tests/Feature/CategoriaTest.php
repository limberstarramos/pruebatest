<?php

namespace Tests\Feature;
use App\Models\Categoria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\Factory;
class CategoriaTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    
    /** @test*/ 
    public function categoria_index(){
        $this->withoutExceptionHandling();
        
        Categoria::factory(3)->create();
         // \App\Models\User::factory(10)->create();
        $response= $this->get('/categoria');
        $response->assertOk();

        $cat= Categoria::all();
        $response->assertViewIs('categorias.index');
        // $response->assertViewHas('categorias', $cat);


    }

    /** @test*/ 
    public function categoria_created(){

        $this->withoutExceptionHandling();
        $response = $this->post('/categoria',[
            'nombre'=>'categoria uno',
            'descripcion'=>'descripcion cat'
        ]);
        $response->assertOk();
        $this->assertCount(1,Categoria::all());
        $cat= Categoria::first();
        $this->assertEquals($cat->nombre,'categoria uno');
        $this->assertEquals($cat->descripcion,'descripcion cat');

    }

    /** @test*/ 
    public function categoria_show(){
        $this->withoutExceptionHandling();
        
        Categoria::factory(1)->create();
        $cat= Categoria::first();
         // \App\Models\User::factory(10)->create();
        $response= $this->get('/categoria/' . $cat->id);
        $response->assertOk();

        // $cat= Categoria::first();
        $response->assertViewIs('categorias.show');
        $response->assertViewHas('cat', $cat);


    }

    /** @test*/ 
    public function categoria_update(){
        $this->withoutExceptionHandling();
        
        Categoria::factory(1)->create();
        $cat= Categoria::first();
            // \App\Models\User::factory(10)->create();
        $response = $this->put('/categoria/' . $cat->id, [
            'nombre'=>'categoria uno',
            'descripcion'=>'descripcion cat'
        ]);
        // $response->assertOk();
        $this->assertCount(1,Categoria::all());

        $cat= $cat->fresh();
        $this->assertEquals($cat->nombre,'categoria uno');
        $this->assertEquals($cat->descripcion,'descripcion cat');
        $response->assertRedirect('/categoria/'. $cat->id);

        // $response->assertViewIs('categorias.show');
        // $response->assertViewHas('cat', $cat);


    }



    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
