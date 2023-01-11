<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMovieRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => "required|max:100|min:0",
            'summary' => "required",
            'cover_image' => "nullable|mimes:jpeg,png,jpg|max:10000",
            'genres' => "required",
            'author' => "required",
            'tags' => "required",
            'imdb_rate' => "required|numeric"
        ];
    }
}
