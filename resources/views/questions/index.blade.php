<x-layouts.app :title="'Todas las Preguntas'">

    <h1 class="text-2xl font-bold mb-4">Todas las Preguntas</h1>

    <ul class="space-y-4">
        @forelse($questions as $question)
            <li class="border p-4 rounded hover:bg-gray-50 dark:hover:bg-gray-800">
                <a href="{{ route('questions.show', $question) }}" class="font-semibold text-blue-600 hover:underline">
                    {{ $question->title }}
                </a>
                <p class="text-xs text-gray-500">
                    Por {{ $question->user->name }} | {{ $question->created_at->diffForHumans() }}
                </p>
            </li>
        @empty
            <li class="text-gray-400">No hay preguntas todavía.</li>
        @endforelse
    </ul>

    {{ $questions->links() }} <!-- Si usas paginación -->

</x-layouts.app>
