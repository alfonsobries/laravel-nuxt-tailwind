<?php

namespace App\Http\Requests;

use App\Models\Layout;
use Illuminate\Foundation\Http\FormRequest;

class LayoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->layout
            ? $this->user()->can('update', $this->layout)
            : $this->user()->can('store', Layout::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->layout) {
            return [
                'provider_id' => 'nullable|numeric|exists:providers,id',
                'name' => 'nullable',
                'slug' => 'nullable|alpha_dash|unique:layouts,slug,' . $this->layout->id,
            ];
        }

        return [
            'provider_id' => 'numeric|exists:providers,id|required',
            'name' => 'required',
            'slug' => 'nullable|alpha_dash|unique:layouts,slug',
        ];
    }
}
