<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    // Mostrar el formulario para crear una nueva pregunta
    public function create()
    {
        return view('questions.create'); // Creamos esta vista
    }

    public function index()
    {
        $questions = Question::latest()->paginate(10); // o ->get() si no quieres paginar
        return view('questions.index', compact('questions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $question = auth()->user()->questions()->create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('question.show', $question)->with('success', 'Pregunta creada correctamente.');
    }


    // Mostrar detalle de la pregunta
    public function show(Question $question)
    {
        return view('questions.show', compact('question'));
    }

    // Mostrar el formulario de edición
    public function edit(Question $question)
    {
        $this->authorize('update', $question);
        return view('questions.edit', compact('question'));
    }

    // Actualizar la pregunta
    public function update(Request $request, Question $question)
    {
        $this->authorize('update', $question);

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $question->update($request->only('title', 'content'));

        return redirect()->route('question.show', $question)->with('success', 'Pregunta actualizada correctamente.');
    }

    // Eliminar la pregunta
    public function destroy(Question $question)
    {
        // Verificamos que solo el autor pueda eliminar su pregunta (opcional)
        if (auth()->id() !== $question->user_id) {
            abort(403, 'No tienes permiso para eliminar esta pregunta.');
        }

        $question->delete();

        // Redirigir al dashboard en lugar del home
        return redirect()->route('dashboard')->with('success', 'La pregunta se eliminó correctamente.');
    }
}
