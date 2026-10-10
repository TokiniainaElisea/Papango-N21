<?php
namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProviderStoreRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name_provider' => ['nullable', 'string'],
            'mail'          => ['nullable', 'string'],
            'phone'         => ['nullable', 'min:9'],
            'adress'        => ['nullable', 'string'],
            'town'          => ['nullable', 'string'],
            'country'       => ['nullable', 'string'],
            'name_contact'  => ['nullable', 'string'],
            'note'          => ['nullable', 'string'],
        ];
    }
}
