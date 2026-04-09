<?php

namespace  App\Modules\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends FormRequest
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
            'shop_id' =>  ['required'],
            'order_ids' =>  ['required'],
            'upload_payment' =>  ['required']
        ];
    }

    public function messages(): array
    {
        return [
            'shop_id.required' => 'Shop không tồn tại.',
            'order_ids.required' => 'Không có hóa đơn nào.',
            'upload_payment.required' => 'Chưa tải file lên',
        ];
    }
}
