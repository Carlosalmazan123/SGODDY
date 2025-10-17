<?php

namespace Sdkconsultoria\OpenAiApi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssistantRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'template_id' => 'required|integer|exists:Sdkconsultoria\OpenAiApi\Models\Template,id',
            'waba_phone_id' => 'required|integer|exists:Sdkconsultoria\OpenAiApi\Models\WabaPhone,id',
            'file' => 'required|extensions:csv',
        ];
    }
}
