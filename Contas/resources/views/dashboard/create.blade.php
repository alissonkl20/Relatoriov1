<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nova despesa</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-black text-white scheme-dark min-h-screen p-6">
    <main class="max-w-xl mx-auto">
        <a href="{{ route('dashboard.index') }}" class="inline-block mb-6">
            ← Voltar às despesas
        </a>

        <div class="bg-[#1b1b1b] border border-[#333] rounded-xl p-7">
            <h1 class="text-2xl font-bold mb-2">Nova despesa</h1>
            <p class="mb-6">Informe os dados da despesa.</p>

            @if ($errors->any())
                <div class="mb-5 p-4 bg-[#281818] border border-red-500/40 rounded-lg">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if ($categorias->isEmpty())
                <p class="mb-5">
                    Cadastre uma categoria antes de adicionar uma despesa.
                    <a href="{{ route('categorias.create') }}">
                        Criar categoria
                    </a>
                </p>
            @else
                <form action="{{ route('dashboard.store') }}" method="POST">
                    @csrf
                    <div class="mb-5">
                        <label for="nome" class="block mb-2 font-medium">Nome da despesa</label>
                        <input type="text" id="nome" name="nome" value="{{ old('nome') }}" maxlength="255"
                               required autofocus
                               class="w-full bg-[#111] border border-[#444] text-white placeholder-white rounded-lg p-3 focus:outline-none focus:border-orange-500">
                    </div>

                    <div class="mb-5">
                        <label for="valor" class="block mb-2 font-medium">Valor (R$)</label>
                        <input type="number" id="valor" name="valor" value="{{ old('valor') }}" min="0" step="0.01"
                               required
                               class="w-full bg-[#111] border border-[#444] text-white rounded-lg p-3 focus:outline-none focus:border-orange-500">
                    </div>

                    <div class="mb-6">
                        <label for="categoria_id" class="block mb-2 font-medium">Categoria</label>
                        <select id="categoria_id" name="categoria_id" required
                                class="w-full bg-[#111] border border-[#444] text-white rounded-lg p-3 focus:outline-none focus:border-orange-500">
                            <option value="">Selecione uma categoria</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}" @selected(old('categoria_id') === $categoria->id)>
                                    {{ $categoria->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                                class="flex-1 bg-orange-700 hover:bg-orange-800 text-white font-semibold p-3 rounded-lg">
                            Salvar despesa
                        </button>
                        <a href="{{ route('dashboard.index') }}"
                           class="flex-1 text-center bg-[#303030] hover:bg-[#404040] p-3 rounded-lg">
                            Cancelar
                        </a>
                    </div>
                </form>
            @endif
        </div>
    </main>
</body>
</html>
