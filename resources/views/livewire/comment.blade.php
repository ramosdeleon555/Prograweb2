<div class="mt-4 border-t border-gray-700 pt-4">
    <h3 class="text-sm font-semibold text-gray-300 mb-2">Comentarios</h3>

    <button wire:click="toggle" class="text-blue-400 text-xs mb-3 hover:underline">
        {{ $showForm ? 'Cancelar' : 'Agregar comentario' }}
    </button>

    @if($showForm)
        <form wire:submit.prevent="add" class="mb-3">
            <textarea wire:model="content" rows="2" placeholder="Escribe tu comentario..." class="w-full bg-gray-800 text-sm text-gray-200 rounded p-2"></textarea>
            @error('content') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            <button type="submit" class="mt-1 bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded">Comentar</button>
        </form>
    @endif

    <ul class="space-y-2">
        @foreach($comments as $comment)
            <li class="bg-gray-800 rounded p-2">
                <p class="text-gray-200 text-sm">{{ $comment->content }}</p>
                <p class="text-xs text-gray-500 mt-1">
                    {{ $comment->user->name ?? 'Usuario desconocido' }} |
                    {{ $comment->created_at->diffForHumans() }}
                </p>
            </li>
        @endforeach
    </ul>
</div>
