<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'doctor_id' => 'required|exists:doctors,id',
            'day' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => ['required', 'date_format:H:i', function ($attribute, $value, $fail) {
                if (strtotime($value) <= strtotime($this->start_time)) {
                    $fail('The end time must be after the start time.');
                }
            }],
        ];
    }
}
