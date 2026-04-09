<?php

namespace  App\Modules\Admin\Requests;

use App\Models\Supplier;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SUpdatePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $supplier = Supplier::where('auth_id', Auth::id())->first();
        if(request()->get('shop_id') == $supplier->id){
            return true;
        }
        
        return false;
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
