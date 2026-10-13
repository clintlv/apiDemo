<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateInventoryAdjustRequest extends FormRequest
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
            'product_batch_id' => 'required|exists:product_batches,id',
            'inventory_adjust_reason_id' => 'required|exists:inventory_adjust_reasons,id',
            'new_qty' => 'required|numeric|min:0',
            'remark' => 'nullable|string',
        ];
    }
}
