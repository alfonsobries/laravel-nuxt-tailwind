<?php

namespace App\Http\Requests;

use App\Models\Column;
use Illuminate\Foundation\Http\FormRequest;

class ColumnRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->column
            ? $this->user()->can('update', $this->column)
            : $this->user()->can('store', Column::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->column) {
            return [
                'layout_id' => 'nullable|numeric|exists:layouts,id',
                'name' => 'nullable',
                'slug' => 'nullable|alpha_dash',
                'type' => 'nullable|in:' . Column::typeOptions()->implode(','),
                'default' => 'nullable',
                'when_duplicated' => 'nullable|in:' . Column::actionOptions()->implode(','),
                'required' => 'nullable|boolean',
                'published' => 'nullable|boolean',
                'settings' => 'nullable|array',
            ];
        }

        return [
            'layout_id' => 'numeric|exists:layouts,id|required',
            'name' => 'required',
            'slug' => 'nullable|alpha_dash',
            'type' => 'required|in:' . Column::typeOptions()->implode(','),
            'default' => 'nullable',
            'when_duplicated' => 'required|in:' . Column::actionOptions()->implode(','),
            'required' => 'nullable|boolean',
            'published' => 'nullable|boolean',
            'settings' => 'nullable|array',
        ];
    }
}
