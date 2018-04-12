<?php

namespace App\Http\Controllers\Admin;

use App\Mail\UserRegistered;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    private $perPage = 10;

    public function index(Request $request)
    {
        $usersQ = User::query();

        if ($request->filled('type')) {
            $usersQ->where('is_admin', (bool)$request->input('type'));
        }
        $usersQ->orderBy('surname')->orderBy('name')->orderBy('patronymic');
        $users = $usersQ->orderBy('name')->paginate($this->perPage);

        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'       => 'required|string|max:255',
            'surname'    => 'nullable|string|max:255',
            'patronymic' => 'nullable|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users',
            'phone'      => 'required|string|max:255',
            'password'   => 'required|string|min:6|confirmed',
            'is_admin'   => 'nullable|boolean',
        ]);


        $user = (new User())->fill($validatedData);
        try {
            $user->save();
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.users.create')
                ->withInput()
                ->with('error', 'Ой! Что-то пошло не так...');
        }

        \Mail::send(new UserRegistered($user));

        return redirect()
            ->route('admin.users.index')
            ->with('status', "Новый пользователь <strong>{$user->fullName}</strong> успешно добавлен!");
    }

    public function edit(User $user)
    {
        abort_if($user->id == 1 && $user->id != \Auth::user()->id, 403);

        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user)
    {
        abort_if($user->id == 1 && $user->id != \Auth::user()->id, 403, 'Доступ запрещен!');

        $validatedData = $request->validate([
            'name'       => 'required|string|max:255',
            'surname'    => 'nullable|string|max:255',
            'patronymic' => 'nullable|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users,id,' . $request->input('email'),
            'phone'      => 'required|string|max:255',
            'password'   => 'nullable|string|min:6',
            'is_admin'   => 'nullable|boolean',
        ]);

        try {
            if ($user->id == 1) {
                $validatedData['is_admin'] = true;
            }
            if (empty($validatedData['password'])) {
                unset($validatedData['password']);
            }

            $user->fill($validatedData);
            $user->save();
        } catch (\Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Ой! Что-то пошло не так...');
        }

        return redirect()
            ->route('admin.users.index')
            ->with('status', "Пользователь <strong>{$user->fullName}</strong> успешно обновлен!");
    }

    public function destroy(User $user)
    {
        $user->load([
            'orders',
            'products',
        ]);
        try {
            // Clear shopping cart products
            if ($user->products->isNotEmpty()) {
                $user->products()->delete();
            }

            // If user have orders - soft delete
            if ($user->orders->isNotEmpty()) {
                $user->delete();
            } else {
                $user->forceDelete();
            }

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Ой! Что-то пошло не так...');
        }

        return redirect()
            ->route('admin.users.index')
            ->with('status', "Пользователь <strong>{$user->fullName}</strong> успешно удален!");
    }
}
