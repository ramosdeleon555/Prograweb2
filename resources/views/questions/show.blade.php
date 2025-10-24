<x-forum.layouts.app>

<div class="flex items-center gap-2 w-full my-8">
    
    <livewire:heart :heartable="$question" />

    <div class="w-full">
        <div class="flex justify-between items-start">
            <h2 class="text-2xl font-bold md:text-3xl">
               {{ $question->title }}
            </h2>

            <!-- Botón de regresar (arriba a la derecha) -->
            <a href="{{ route('dashboard') }}"
               class="rounded-md bg-gray-700 hover:bg-gray-600 text-white text-xs font-semibold px-3 py-1 transition">
                ← Regresar al Dashboard
            </a>
        </div>

        <div class="flex justify-between mt-2">
            <p class="text-xs text-gray-500">
                <span class="font-semibold">{{ $question->user->name }}</span> |
                {{ $question->category->name ?? 'Sin categoría' }} |
                {{ $question->created_at->diffForHumans() }}
            </p>

            <div class="flex items-center gap-2">
                @can('update', $question)
                    <a href="{{ route('questions.edit', $question) }}" class="text-xs font-semibold hover:underline text-blue-400">
                        Editar
                    </a>
                @endcan

                @can('delete', $question)
                    <form action="{{ route('questions.destroy', $question) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta pregunta?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="rounded-md bg-red-600 hover:bg-red-500 px-2 py-1 text-xs font-semibold text-white cursor-pointer">
                            Eliminar
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </div>
</div>

<div class="my-4">
    <p class="text-gray-200">
        {{ $question->content }}
    </p>

    <livewire:comment-section :commentable="$question" />
</div>

<ul class="space-y-4">
    @foreach($question->answers as $answer)
        <li>
            <div class="flex items-start gap-2">
               <livewire:heart :heartable="$answer" wire:key="answer-heart-{{ $answer->id }}" />

                <div>
                    <p class="text-sm text-gray-300">
                        {{ $answer->content }}
                    </p>
                    <p class="text-xs text-gray-500">
                        {{ $answer->user->name }} | 
                        {{ $answer->created_at->diffForHumans() }}
                    </p>

                    <livewire:comment-section :commentable="$answer" wire:key="answer-comment-{{ $answer->id }}" />
                </div>
            </div>  
        </li>
    @endforeach
</ul>

<div class="mt-8">
    <h3 class="text-lg font-semibold mb-2">Tu Respuesta...</h3>

    <form action="{{ route('answers.store', $question) }}" method="POST">
        @csrf

        <div class="mb-2">
            <textarea name="content" rows="6" class="w-full p-2 border rounded-md text-xs" required></textarea>
            @error('content')
                <span class="block text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit"
                class="rounded-md bg-blue-600 hover:bg-blue-500 px-4 py-2 text-white cursor-pointer">
            Enviar Respuesta
        </button>
    </form>
</div>

<!-- Botón de regresar (abajo) -->
<div class="mt-8">
    <a href="{{ route('dashboard') }}"
       class="inline-block px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded transition text-sm font-semibold">
        ← Regresar al Dashboard
    </a>
</div>

</x-forum.layouts.app>
