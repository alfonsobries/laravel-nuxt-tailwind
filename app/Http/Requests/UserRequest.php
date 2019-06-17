<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user
            ? $this->user()->can('update', $this->user)
            : $this->user()->can('store', User::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->user) {
            return [
                'name' => 'nullable',
                'email' => 'nullable|email|unique:users,email,' . $this->user->id,
                'password' => 'nullable|min:6',
                'role' => 'nullable|in:' . $this->user()->assignable_roles->implode(','),
            ];
        }

        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:' . $this->user()->assignable_roles->implode(','),
        ];
    }

    public function validated()
    {
        $validated = parent::validated();
        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }
        return $validated;
    }
}
