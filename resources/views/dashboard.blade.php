<x-layouts.app :title="__('Dashboard')"> 
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        {{-- Botones de acción y saludo al usuario --}}
        <div class="flex justify-between items-center mb-4">
            <div class="flex gap-4">
                <a href="{{ route('questions.create') }}" 
                   class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-500">
                   Nueva Pregunta
                </a>

                <a href="{{ route('questions.index') }}" 
                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">
                   Ver Todas las Preguntas
                </a>
            </div>

            {{-- Saludo con nombre del usuario alineado a la derecha --}}
            <div class="text-white font-semibold text-lg md:text-xl">
                Bienvenido, {{ Auth::user()->name }}
            </div>
        </div>

        {{-- Últimas preguntas dinámicas --}}
        <div class="mt-6">
            <h2 class="text-xl font-bold mb-2">Últimas Preguntas</h2>
            <ul class="space-y-4">
                @forelse($questions as $question)
                    <li class="border border-neutral-200 dark:border-neutral-700 p-4 rounded hover:bg-gray-50 dark:hover:bg-gray-800">
                        <a href="{{ route('questions.show', $question) }}" class="font-semibold text-blue-600 hover:underline">
                            {{ $question->title }}
                        </a>
                        <p class="text-xs text-gray-500">
                            Por {{ $question->user->name }} | {{ $question->created_at->diffForHumans() }}
                        </p>
                        <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">
                            {{ Str::limit($question->content, 100) }}
                        </p>
                    </li>
                @empty
                    <li class="text-gray-400">No hay preguntas todavía.</li>
                @endforelse
            </ul>
        </div>

    </div>
</x-layouts.app>
