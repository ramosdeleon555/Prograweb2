<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;

use App\Http\Controllers\Controller; // <- Esto es clave

class AnswerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Funciona solo si extiendes Controller
    }

    public function create(Question $question)
    {
        return view('answers.create', compact('question'));
    }
    
    public function store(Request $request, Question $question)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $question->answers()->create([
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back();
    }
}
