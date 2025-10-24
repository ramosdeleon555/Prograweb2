<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Question;

class QuestionPolicy
{
    public function update(User $user, Question $question)
    {
        return $user->id === $question->user_id;
    }

    public function delete(User $user, Question $question)
    {
        return $user->id === $question->user_id;
    }
}
