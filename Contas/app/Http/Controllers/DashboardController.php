<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Dashboard;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $selectedCategoriaId = $request->query('categoria_id');

        $query = Dashboard::with('categoriaRelacionada')->latest();

        if (is_string($selectedCategoriaId) && $selectedCategoriaId !== '') {
            $selectedCategoria = Categoria::find($selectedCategoriaId);

            if ($selectedCategoria !== null) {
                $query->where(function (Builder $query) use ($selectedCategoria): void {
                    $query->where('categoria_id', $selectedCategoria->id)
                        ->orWhere(function (Builder $query) use ($selectedCategoria): void {
                            $query->whereNull('categoria_id')
                                ->where('categoria', $selectedCategoria->nome);
                        });
                });
            } else {
                $selectedCategoriaId = '';
            }
        } else {
            $selectedCategoriaId = '';
        }

        $despesas = $query->get();
        $categorias = Categoria::orderBy('nome')->get();

        return view('dashboard.index', compact(
            'despesas',
            'categorias',
            'selectedCategoriaId'
        ));
    }

    public function create(): View
    {
        $categorias = Categoria::orderBy('nome')->get();

        return view('dashboard.create', compact('categorias'));
    }

    public function postDashboard(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
            'categoria_id' => 'required|exists:categorias,id',
        ]);
        $categoria = Categoria::findOrFail($validated['categoria_id']);

        Dashboard::create([
            'id' => (string) Str::uuid(),
            'nome' => $validated['nome'],
            'valor' => $validated['valor'],
            'categoria' => $categoria->nome,
            'categoria_id' => $categoria->id,
        ]);

        return redirect()
            ->route('dashboard.index')
            ->with('success', 'Registro criado com sucesso!');
    }

    public function edit(string $id): View
    {
        $dashboard = Dashboard::findOrFail($id);
        $categorias = Categoria::orderBy('nome')->get();

        return view('dashboard.edit', compact(
            'dashboard',
            'categorias'
        ));
    }

    public function putDashboard(Request $request, string $id): RedirectResponse
    {
        $dashboard = Dashboard::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
            'categoria_id' => 'required|exists:categorias,id',
        ]);
        $categoria = Categoria::findOrFail($validated['categoria_id']);

        $dashboard->update([
            'nome' => $validated['nome'],
            'valor' => $validated['valor'],
            'categoria' => $categoria->nome,
            'categoria_id' => $categoria->id,
        ]);

        return redirect()
            ->route('dashboard.index')
            ->with('success', 'Registro atualizado com sucesso!');
    }

    public function deleteDashboard(string $id): RedirectResponse
    {
        $dashboard = Dashboard::findOrFail($id);

        $dashboard->delete();

        return redirect()
            ->route('dashboard.index')
            ->with('success', 'Registro excluído com sucesso!');
    }
}
