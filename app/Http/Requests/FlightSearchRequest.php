<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FlightSearchRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules(): array {
        return [
            'origin' => 'required|string',
            'destination' => 'required|string',
            'date' => 'required|date',
            'sort' => 'nullable|in:asc,desc',
        ];
    }
}
