<x-forum.layouts.app>

<h2 class="text-2xl font-bold mb-4">Editar Pregunta</h2>

<form action="{{ route('questions.update', $question) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label for="title" class="block text-sm font-semibold mb-1">Título</label>
        <input type="text" name="title" id="title" value="{{ old('title', $question->title) }}" class="w-full p-2 border rounded-md text-sm" required>
        @error('title')
            <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-4">
        <label for="content" class="block text-sm font-semibold mb-1">Contenido</label>
        <textarea name="content" id="content" rows="6" class="w-full p-2 border rounded-md text-sm" required>{{ old('content', $question->content) }}</textarea>
        @error('content')
            <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="rounded-md bg-green-600 hover:bg-green-500 px-4 py-2 text-white cursor-pointer">
        Guardar Cambios
    </button>
</form>

</x-forum.layouts.app>
