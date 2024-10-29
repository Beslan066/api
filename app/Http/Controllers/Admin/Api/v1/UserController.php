<?php

namespace App\Http\Controllers\Admin\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreRequest;
use App\Http\Requests\Admin\User\UpdateRequest;
use App\Http\Resources\Role\RoleResource;
use App\Http\Resources\User\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return UserResource::collection($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        // Получение валидированных данных из запроса
        $data = $request->validated();

        // Сохранение изображения, если оно загружено
        if (isset($data['avatar'])) {
            $data['avatar'] = Storage::put('avatars', $request->file('avatar'));
            $data['avatar'] = str_replace('avatars/', '', $data['avatar']);
        }

        // Создание нового пользователя с валидированными данными
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role_id = $data['role_id'];
        $user->avatar = $data['avatar'] ?? null;
        $user->password = Hash::make($data['password']);
        $user->save();

        // Возвращение ресурса пользователя
        return new UserResource($user);
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, User $user)
    {
        // Получение валидированных данных
        $data = $request->validated();

        // Проверка и обновление аватара
        if ($request->hasFile('avatar')) {
            // Удаляем старый аватар, если он существует
            if ($user->avatar) {
                Storage::delete('avatars/' . $user->avatar);
            }

            // Сохраняем новый аватар
            $data['avatar'] = Storage::put('avatars', $request->file('avatar'));
            $data['avatar'] = str_replace('avatars/', '', $data['avatar']);
        }

        // Обновляем данные пользователя
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        // Возвращение ресурса пользователя
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
           "message" => "Пользователь был успешно обновлен",
           200
        ]);
    }
}
