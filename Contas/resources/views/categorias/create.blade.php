<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nova categoria</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-black text-white scheme-dark min-h-screen p-6">

    <main class="max-w-xl mx-auto">

        <a href="{{ route('categorias.index') }}"
           class="inline-block mb-6">
            ← Voltar às categorias
        </a>

        <div class="bg-[#1b1b1b] border border-[#333] rounded-xl p-7">

            <h1 class="text-2xl font-bold mb-2">
                Nova categoria
            </h1>

            <p class="mb-6">
                Cadastre uma categoria para organizar suas despesas.
            </p>

            @if ($errors->any())
                <div class="mb-5 p-4 bg-[#281818] border border-red-500/40 rounded-lg">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('categorias.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="nome" class="block mb-2 font-medium">
                        Nome da categoria
                    </label>

                    <input
                        type="text"
                        id="nome"
                        name="nome"
                        value="{{ old('nome') }}"
                        placeholder="Ex.: Mercado"
                        maxlength="255"
                        required
                        autofocus
                        class="w-full bg-[#111] border border-[#444] text-white placeholder-white rounded-lg p-3 focus:outline-none focus:border-orange-500"
                    >
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                            class="flex-1 bg-orange-700 hover:bg-orange-800 text-white font-semibold p-3 rounded-lg">
                        Salvar categoria
                    </button>

                    <a href="{{ route('categorias.index') }}"
                       class="flex-1 text-center bg-[#303030] hover:bg-[#404040] p-3 rounded-lg">
                        Cancelar
                    </a>
                </div>
            </form>

        </div>
    </main>
</body>
</html>
