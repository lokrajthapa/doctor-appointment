<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
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
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_time' => 'required|date|after_or_equal:today',
            'department_name' => 'required|string|max:255',
            'reason' => 'required|string',
        ];
    }

    public function messages(){
        return [
            'appointment_date.after_or_equal' => 'The appointment date must be today or a future date.',
        ];

    }
}
