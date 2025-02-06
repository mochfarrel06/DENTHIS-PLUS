<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class DoctorScheduleUpdateRequest extends FormRequest
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
            'waktu_periksa' => ['required', 'in:5,10,15,30,60'],
            'waktu_jeda' => ['required', 'in:5,10,15,30,60'],
            'hari' => ['nullable', 'array', 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday'],
            'jam_mulai' => ['nullable', 'array'],
            'jam_selesai' => ['nullable', 'array'],
        ];
    }
}
