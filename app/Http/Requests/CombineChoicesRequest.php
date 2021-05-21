<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CombineChoicesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Verify that client has auth cookie
        $poll = $this->route('poll');
        $cookie = $this->cookie('splashpoll_poll_owner_' . $poll->id);

        if ($cookie != $poll->id) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $poll = $this->route('poll');
        $choices = $poll->choices;

        return [
            'choices' => 'required|array|min:2',
            'choices.*' => [
                'required',
                'numeric',
                'distinct',
                function ($attribute, $value, $fail) use ($choices) {
                    // Ensure that choices belong to this poll
                    if (!$choices->contains($value)) {
                        $fail($attribute . ' is invalid, does not belong to poll.');
                    }
                },
            ],
            'text' => 'required|string|max:150'
        ];
    }
}
