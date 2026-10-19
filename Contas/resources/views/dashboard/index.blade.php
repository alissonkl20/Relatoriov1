<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Despesas</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-black text-white scheme-dark min-h-screen p-6">
    <main class="max-w-5xl mx-auto">
        <header class="flex justify-between items-center flex-wrap gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold">
                    Minhas <span>despesas</span>
                </h1>
                <p class="mt-2">Acompanhe e organize seus gastos.</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('categorias.index') }}"
                   class="bg-[#303030] hover:bg-[#404040] px-4 py-3 rounded-lg">
                    Categorias
                </a>
                <a href="{{ route('dashboard.create') }}"
                   class="bg-orange-500 hover:bg-orange-600 px-5 py-3 rounded-lg font-semibold">
                    + Nova despesa
                </a>
            </div>
        </header>

        <div class="bg-[#1b1b1b] border border-[#333] rounded-xl p-6">
            @if (session('success'))
                <div class="bg-[#252018] border border-orange-500/40 p-4 rounded-lg mb-5">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('dashboard.index') }}" method="GET" class="flex flex-wrap gap-3 mb-6">
                <label for="categoria_id" class="sr-only">Filtrar por categoria</label>
                <select id="categoria_id" name="categoria_id"
                        class="bg-[#111] border border-[#444] text-white rounded-lg px-3 py-2">
                    <option value="">Todas as categorias</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}" @selected($selectedCategoriaId === $categoria->id)>
                            {{ $categoria->nome }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="bg-[#303030] hover:bg-[#404040] px-4 py-2 rounded-lg">
                    Filtrar
                </button>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-[#252525]">
                        <tr>
                            <th class="p-4">Despesa</th>
                            <th class="p-4">Categoria</th>
                            <th class="p-4">Valor</th>
                            <th class="p-4">Data</th>
                            <th class="p-4 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($despesas as $despesa)
                            <tr class="border-t border-[#333] hover:bg-[#242424]">
                                <td class="p-4 font-medium">{{ $despesa->nome }}</td>
                                <td class="p-4">
                                    {{ $despesa->categoriaRelacionada?->nome ?? $despesa->categoria }}
                                </td>
                                <td class="p-4">R$ {{ number_format((float) $despesa->valor, 2, ',', '.') }}</td>
                                <td class="p-4">{{ $despesa->created_at->format('d/m/Y') }}</td>
                                <td class="p-4">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('dashboard.edit', $despesa->id) }}"
                                           class="bg-orange-500 hover:bg-orange-600 px-3 py-2 rounded-lg">
                                            Editar
                                        </a>
                                        <form action="{{ route('dashboard.destroy', $despesa->id) }}" method="POST"
                                              onsubmit="return confirm('Deseja excluir esta despesa?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-[#303030] hover:bg-[#484848] border border-[#505050] px-3 py-2 rounded-lg">
                                                Excluir
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center">
                                    Nenhuma despesa cadastrada.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
