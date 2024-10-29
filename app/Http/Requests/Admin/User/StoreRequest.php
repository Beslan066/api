<?php

namespace App\Http\Requests\Admin\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;


class StoreRequest extends FormRequest
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
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|integer',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,webp,png',
        ];
    }

    /**
     * Сообщения об ошибках для валидации.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Это поле должно быть заполнено',
            'name.string' => 'Это поле должно быть строкой',
            'email.required' => 'Это поле должно быть заполнено',
            'email.string' => 'Email должен быть строкой',
            'email.email' => 'Неверный формат почты',
            'email.unique' => 'Эта почта уже используется',
            'password.required' => 'Это поле должно быть заполнено',
            'password.min' => 'Пароль должен содержать минимум 8 символов',
            'password.confirmed' => 'Пароль и подтверждение не совпадают',
            'role_id.required' => 'Роль должна быть выбрана',
            'role_id.integer' => 'Роль должна быть целым числом',
            'avatar.image' => 'Аватар должен быть изображением',
            'avatar.mimes' => 'Аватар должен быть в формате: jpg, jpeg, webp или png',
        ];
    }
}
