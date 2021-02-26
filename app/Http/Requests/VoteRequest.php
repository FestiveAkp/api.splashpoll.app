<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
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

        $openEnded = 'string';
        $multipleChoice = 'numeric|exists:choices,id';
        $singleChoice = 'size:1';
        $manyChoices = 'min:1';

        return [
            'answers' => 'required|array|'.($poll->multipleChoices ? $manyChoices : $singleChoice),
            'answers.*' => 'required|'.($poll->openEnded ? $openEnded : $multipleChoice)
        ];
    }
}
