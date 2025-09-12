<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelSearchRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules(): array {
        return [
            'city' => 'required|string',
            'checkin' => 'required|date',
            'checkout' => 'required|date|after:checkin',
            'sort' => 'nullable|in:asc,desc',
        ];
    }
}
