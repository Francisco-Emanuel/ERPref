<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules as ValidationRules;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('manage-users');
        $users = User::with(['setor', 'roles'])->orderBy('name')->paginate(15);
        return view('users.index', compact('users'));
    }

    /**
     * NOVO MÉTODO: Mostra o formulário para criar um novo usuário.
     */
    public function create()
    {
        $this->authorize('manage-users');
        $setores = Setor::orderBy('nome')->get();
        $roles = Role::orderBy('name')->get();
        return view('users.create', compact('setores', 'roles'));
    }

    /**
     * NOVO MÉTODO: Salva o novo usuário no banco de dados.
     */
    public function store(Request $request)
    {
        $this->authorize('manage-users');

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', ValidationRules\Password::defaults()],
            'setor_id' => 'nullable|exists:setores,id',
            'roles' => 'sometimes|array'
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'setor_id' => $validatedData['setor_id'],
        ]);

        $user->syncRoles($request->roles ?? []);

        return redirect()->route('users.index')->with('success', 'Novo usuário criado com sucesso!');
    }

    public function edit(User $user)
    {
        $this->authorize('manage-users');
        $setores = Setor::orderBy('nome')->get();
        $roles = Role::orderBy('name')->get();
        return view('users.edit', compact('user', 'setores', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('manage-users');

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'setor_id' => 'nullable|exists:setores,id',
            'roles' => 'sometimes|array'
        ]);

        $user->update($validatedData);
        $user->syncRoles($request->roles ?? []);

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
    }
}