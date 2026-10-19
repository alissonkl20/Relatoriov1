<?php

use App\Models\Categoria;
use App\Models\Dashboard;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('expense and category pages render and use database categories', function () {
    $categoria = Categoria::create(['nome' => 'Casa']);
    Dashboard::create([
        'nome' => 'Despesa antiga',
        'valor' => 60,
        'categoria' => 'Casa',
    ]);

    $this->get(route('dashboard.index'))
        ->assertOk()
        ->assertSee('Despesa antiga')
        ->assertSee('Casa');

    $this->get(route('categorias.index'))
        ->assertOk()
        ->assertSee('Casa');

    $this->get(route('categorias.create'))->assertOk();
    $this->get(route('categorias.edit', $categoria->id))->assertOk();

    $this->post(route('dashboard.store'), [
        'nome' => 'Aluguel',
        'valor' => '1250.50',
        'categoria_id' => $categoria->id,
    ])->assertRedirect(route('dashboard.index'));

    $this->assertDatabaseHas('dashboards', [
        'nome' => 'Aluguel',
        'categoria' => 'Casa',
        'categoria_id' => $categoria->id,
    ]);

    $this->get(route('dashboard.index', ['categoria_id' => $categoria->id]))
        ->assertOk()
        ->assertSee('Aluguel')
        ->assertSee('Despesa antiga');

    $despesa = Dashboard::where('nome', 'Aluguel')->firstOrFail();
    $this->get(route('dashboard.edit', $despesa->id))->assertOk();
});

test('a category with expenses cannot be deleted', function () {
    $categoria = Categoria::create(['nome' => 'Transporte']);
    Dashboard::create([
        'nome' => 'Passagem',
        'valor' => 5.50,
        'categoria' => $categoria->nome,
        'categoria_id' => $categoria->id,
    ]);

    $this->delete(route('categorias.destroy', $categoria->id))
        ->assertRedirect(route('categorias.index'))
        ->assertSessionHas('error');

    $this->assertDatabaseHas('categorias', ['id' => $categoria->id]);
});
