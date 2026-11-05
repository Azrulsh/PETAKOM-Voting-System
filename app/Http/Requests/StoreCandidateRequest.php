<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCandidateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->type === 'admin';
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],

            'matric_id' => [
                'required',
                'string',
                'max:255',
                Rule::unique('candidates', 'matric_id'),
            ],

            'course' => ['required', 'string', 'max:255'],

            'year' => [
                'required',
                'integer',
                'between:1900,' . date('Y'),
            ],

            'semester' => [
                'required',
                'integer',
                'between:0,2',
            ],

            'position' => [
                'required',
                Rule::in([
                    'Student Affair',
                    'Welfare Exco',
                    'Sports Exco',
                    'Secretary',
                ]),
            ],

            'manifesto' => ['required', 'string', 'max:255'],

            'video_link' => [
                'required',
                'string',
                'max:255',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'ratings' => ['required', 'array', 'min:1'],
            'ratings.*' => ['required', 'numeric', 'between:0,5'],
        ];
    }

    public function messages(): array
    {
        return [
            'matric_id.unique' =>
                'This Matric ID is already registered as a candidate.',

            'image.image' =>
                'Please upload a valid image.',

            'image.max' =>
                'Image size must not exceed 2MB.',

            'position.in' =>
                'Please select a valid position.',
        ];
    }
}
