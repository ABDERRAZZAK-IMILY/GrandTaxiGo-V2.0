<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRatingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'trip_id' => 'required|exists:trips,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'rating.required' => 'Please provide a rating',
            'rating.integer' => 'Rating must be an integer',
            'rating.min' => 'Rating must be at least 1',
            'rating.max' => 'Rating must not exceed 5',
            'comment.max' => 'Comment must not exceed 1000 characters',
        ];
    }
}