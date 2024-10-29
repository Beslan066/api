<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;


class UpdateRequest extends FormRequest
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
        $userId = $this->route('user'); // Получаем ID текущего пользователя из URL

        return [
            'name' => 'sometimes|string|max:255',
            'email' => [
                'sometimes',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($userId), // Игнорируем текущий email пользователя
            ],
            'password' => 'sometimes|nullable|string|min:8|confirmed',
            'role_id' => 'sometimes|integer',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,webp,png',
        ];
    }

    /**
     * Сообщения об ошибках для валидации.
     */
    public function messages(): array
    {
        return [
            'name.string' => 'Имя должно быть строкой',
            'email.email' => 'Некорректный формат почты',
            'email.unique' => 'Эта почта уже используется другим пользователем',
            'password.min' => 'Пароль должен содержать минимум 8 символов',
            'password.confirmed' => 'Подтверждение пароля не совпадает',
            'role_id.integer' => 'Роль должна быть числом',
            'avatar.image' => 'Аватар должен быть изображением',
            'avatar.mimes' => 'Аватар должен быть в формате: jpg, jpeg, webp или png',
        ];
    }
}
