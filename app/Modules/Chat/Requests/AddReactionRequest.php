<?php

namespace App\Modules\Chat\Requests;

class AddReactionRequest extends ChatFormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->permission->checkAuthInRoom($this);
    }
}