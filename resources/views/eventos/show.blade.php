@extends('layouts.app')

@section('title', $evento->titulo . ' — FalaQ')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-12 gap-6">
    <!-- Formulário de Envio de Pergunta (Ticket #007) -->
    <div class="md:col-span-5">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <h4 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">💬 Faça sua Pergunta</h4>
            
            <form action="{{ route('eventos.perguntas.store', $evento->id) }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="conteudo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Texto da Pergunta
                    </label>

                    <!-- Textarea com borda condicional e retenção do texto via old() -->
                    <textarea 
                        name="conteudo" 
                        id="conteudo" 
                        rows="4" 
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 dark:bg-gray-700 dark:text-white @error('conteudo') border-red-500 @else border-gray-300 dark:border-gray-600 @enderror"
                        placeholder="Digite sua dúvida ou comentário para o palestrante..."
                    >{{ old('conteudo') }}</textarea>

                    <!-- Mensagem de Erro de Validação -->
                    @error('conteudo')
                        <p class="mt-1 text-sm text-red-500 font-semibold">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Botão Estilizado com Tailwind (Ticket #008) -->
                <button 
                    type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                >
                    Enviar Pergunta
                </button>
            </form>
        </div>
    </div>

    <!-- Mural de Perguntas (Ticket #008) -->
    <div class="md:col-span-7">
        <div class="flex justify-between items-center mb-4">
            <h4 class="text-xl font-bold text-gray-900 dark:text-white">📋 Perguntas do Evento</h4>
            <span class="text-sm text-gray-500 dark:text-gray-400">Total no Banco: {{ $perguntas->total() }}</span>
        </div>

        <!-- Cards das Perguntas com margem e estilo de balão de chat -->
        @forelse($perguntas as $pergunta)
            <div class="mb-4 bg-white dark:bg-gray-800 p-4 rounded-lg shadow border-l-4 border-blue-500">
                <p class="text-lg text-gray-800 dark:text-gray-100 mb-3">{{ $pergunta->conteudo }}</p>
                <div class="flex justify-between items-center text-xs text-gray-500 dark:text-gray-400">
                    <span>
                        Autor: <strong class="text-gray-700 dark:text-gray-300">{{ $pergunta->user->name ?? 'Anônimo' }}</strong>
                    </span>
                    <span>{{ $pergunta->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        @empty
            <div class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 text-center p-6 rounded-lg">
                Nenhuma pergunta enviada ainda. Seja o primeiro!
            </div>
        @endforelse

        <!-- Botões de Paginação -->
        @if(method_exists($perguntas, 'links'))
            <div class="mt-6 flex justify-center">
                {{ $perguntas->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
