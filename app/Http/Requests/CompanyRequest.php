<?php

namespace App\Http\Requests;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->company
            ? $this->user()->can('update', $this->company)
            : $this->user()->can('store', Company::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->company) {
            return [
                'name' => 'nullable',
                'slug' => 'nullable|alpha_dash|unique:companies,slug,' . $this->company->id,
            ];
        }

        return [
            'name' => 'required',
            'slug' => 'nullable|alpha_dash|unique:companies,slug',
        ];
    }
}
