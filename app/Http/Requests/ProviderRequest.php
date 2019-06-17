<?php

namespace App\Http\Requests;

use App\Models\Provider;
use Illuminate\Foundation\Http\FormRequest;

class ProviderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->provider
            ? $this->user()->can('update', $this->provider)
            : $this->user()->can('store', Provider::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->provider) {
            return [
                'company_id' => 'nullable|numeric|exists:companies,id',
                'name' => 'nullable',
                'slug' => 'nullable|alpha_dash|unique:providers,slug,' . $this->provider->id,
            ];
        }

        return [
            'company_id' => 'numeric|exists:companies,id|required',
            'name' => 'required',
            'slug' => 'nullable|alpha_dash|unique:providers,slug',
        ];
    }
}
