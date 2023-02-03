<?php

namespace App\Http\Requests;

use App\Enums\Products\ThicknessEnum;
use Illuminate\Validation\Rules\Enum;
use App\Enums\Products\TransmissionEnum;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'make' => ['nullable', 'string', 'max:255'],
            'brand' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'year_start' => ['nullable', 'integer'],
            'year_end' => ['nullable', 'integer'],
            'transmission' => ['required', new Enum(TransmissionEnum::class)],
            'thickness_number' => ['required', 'integer'],
            'thickness' => ['required', new Enum(ThicknessEnum::class)],
            'stock_number' => ['nullable', 'string', 'max:255'],
            'enterex_price' => ['nullable', 'numeric'],
            'price' => ['required', 'numeric'],
            'notes' => ['nullable', 'string', 'max:255'],
        ];
    }
}
