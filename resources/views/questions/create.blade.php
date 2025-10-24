<x-forum.layouts.app>
    <div class="flex justify-between items-center my-4">
        <h2 class="text-2xl font-bold">Crear Nueva Pregunta</h2>

        <!-- Botón para regresar al Dashboard -->
        <a href="{{ route('dashboard') }}" 
           class="bg-gray-700 hover:bg-gray-600 text-white text-sm font-semibold px-4 py-2 rounded-md transition">
            ← Regresar al Dashboard
        </a>
    </div>

    <form action="{{ route('questions.store') }}" method="POST" class="bg-gray-900 p-6 rounded-lg shadow-md">
        @csrf

        <!-- Campo: Título -->
        <div class="mb-4">
            <label class="block text-gray-300 mb-1 font-semibold">Título</label>
            <input 
                type="text" 
                name="title" 
                class="w-full p-2 rounded-md border border-gray-400 bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                value="{{ old('title') }}" 
                required
            >
            @error('title')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- Campo: Contenido -->
        <div class="mb-4">
            <label class="block text-gray-300 mb-1 font-semibold">Contenido</label>
            <textarea 
                name="content" 
                rows="6" 
                class="w-full p-2 rounded-md border border-gray-400 bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
            >{{ old('content') }}</textarea>
            @error('content')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- Botón para publicar -->
        <button 
            type="submit" 
            class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-md font-semibold transition">
            Publicar Pregunta
        </button>
    </form>
</x-forum.layouts.app>
