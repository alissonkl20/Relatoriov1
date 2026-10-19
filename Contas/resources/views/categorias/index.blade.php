<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gerenciar categorias</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-black text-white scheme-dark min-h-screen p-6">

    <main class="max-w-5xl mx-auto">

        <header class="flex justify-between items-center flex-wrap gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold">
                    Gerenciar categorias
                </h1>
                <p class="mt-2">
                    Cadastre e organize suas categorias de despesas.
                </p>
            </div>

            <a href="{{ route('categorias.create') }}"
               class="bg-orange-500 hover:bg-orange-600 px-5 py-3 rounded-lg font-semibold">
                + Nova categoria
            </a>
        </header>

        <div class="bg-[#1b1b1b] border border-[#333] rounded-xl p-6">

            <div class="flex gap-3 mb-6">
                <a href="{{ route('dashboard.index') }}"
                   class="bg-[#303030] hover:bg-[#404040] px-4 py-2 rounded-lg">
                    Voltar às despesas
                </a>
            </div>

            @if (session('success'))
                <div class="bg-[#252018] border border-orange-500/40 p-4 rounded-lg mb-5">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-[#281818] border border-red-500/40 p-4 rounded-lg mb-5">
                    {{ session('error') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">

                    <thead class="bg-[#252525]">
                        <tr>
                            <th class="p-4">Nome</th>
                            <th class="p-4">Despesas associadas</th>
                            <th class="p-4 text-center">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($categorias as $categoria)
                            <tr class="border-t border-[#333] hover:bg-[#242424]">

                                <td class="p-4 font-medium">
                                {{ $categoria->nome }}
                                </td>

                                <td class="p-4">
                                    {{ $categoria->dashboards_count }}
                                </td>

                                <td class="p-4">
                                    <div class="flex justify-center gap-2">

                                        <a href="{{ route('categorias.edit', $categoria->id) }}"
                                           class="bg-orange-500 hover:bg-orange-600 px-3 py-2 rounded-lg">
                                            Editar
                                        </a>

                                        <form action="{{ route('categorias.destroy', $categoria->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Deseja excluir esta categoria?')">
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
                                <td colspan="3" class="p-8 text-center">
                                    Nenhuma categoria cadastrada.
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
