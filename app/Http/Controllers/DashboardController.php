<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question; // Para traer las preguntas

class DashboardController extends Controller
{
    public function index()
    {
        $questions = Question::latest()->take(5)->get(); // últimas 5 preguntas
        return view('dashboard', compact('questions'));
    }
}
