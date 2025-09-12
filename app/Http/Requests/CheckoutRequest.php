<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize() { return auth()->check(); }

    public function rules(): array {
        return [
            'currency' => 'required|in:INR,USD',
            'contact.name' => 'required|string',
            'contact.email' => 'required|email',
            'contact.phone' => 'required|string',
        ];
    }
}
