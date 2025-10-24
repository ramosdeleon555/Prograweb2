<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Component;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CommentSection extends Component
{
    public Model $commentable;
    public bool $showForm = false;
    public string $content = '';
    public $comments = [];

    public function mount(Model $commentable)
    {
        // Asignamos el modelo comentable (pregunta o respuesta)
        $this->commentable = $commentable;

        // Evita el error de foreach si no hay relación o está vacía
        if (method_exists($commentable, 'comments')) {
            $this->comments = $commentable->comments()->latest()->get();
        } else {
            $this->comments = collect(); // colección vacía para evitar null
        }
    }

    public function add()
    {
        $this->validate([
            'content' => 'required|string|max:255',
        ]);

        // Crea un nuevo comentario asociado al modelo padre
        $this->commentable->comments()->create([
            'content' => $this->content,
            'user_id' => Auth::id() ?? 1, // ⚠️ si no hay auth, usa 1 como temporal
        ]);

        // Refresca la lista de comentarios después de agregar uno nuevo
        $this->comments = $this->commentable->comments()->latest()->get();

        // Limpia el formulario
        $this->reset('content', 'showForm');
    }

    public function toggle()
    {
        $this->showForm = !$this->showForm;
    }

    public function render()
    {
        return view('livewire.comment', [
            'comments' => $this->comments,
        ]);
    }
}
