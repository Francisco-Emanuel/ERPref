<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules as ValidationRules;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('create-users');
        $users = User::with(['departamento', 'roles'])->orderBy('name')->paginate(15);
        return view('users.index', compact('users'));
    }

    /**
     * NOVO MÉTODO: Mostra o formulário para criar um novo usuário.
     */
    public function create()
    {
        $this->authorize('create-users');
        $departamentos = Departamento::orderBy('nome')->get();
        $roles = Role::orderBy('name')->get();
        return view('users.create', compact('departamentos', 'roles'));
    }

    /**
     * NOVO MÉTODO: Salva o novo usuário no banco de dados.
     */
    public function store(Request $request)
    {
        $this->authorize('create-users');

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', ValidationRules\Password::defaults()],
            'departamento_id' => 'nullable|exists:departamentos,id',
            'roles' => 'sometimes|array'
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'departamento_id' => $validatedData['departamento_id'],
        ]);

        $user->syncRoles($request->roles ?? []);

        return redirect()->route('users.index')->with('success', 'Novo usuário criado com sucesso!');
    }

    public function edit(User $user)
    {
        $this->authorize('create-users');
        $departamentos = Departamento::orderBy('nome')->get();
        $roles = Role::orderBy('name')->get();
        return view('users.edit', compact('user', 'departamentos', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('create-users');

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'departamento_id' => 'nullable|exists:departamentos,id',
            'roles' => 'sometimes|array'
        ]);

        $user->update($validatedData);
        $user->syncRoles($request->roles ?? []);

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
    }
    public function getUserDetails(User $user)
{
    // Carrega o relacionamento com o departamento para garantir que os dados venham juntos
    $user->load('departamento');

    // Retorna os dados em formato JSON com as chaves que o JavaScript espera
    return response()->json([
        'departamento_nome' => $user->departamento->nome ?? 'Não definido',
        // Supondo que o "local" padrão de um utilizador é o seu próprio departamento.
        // Você pode alterar esta lógica se tiver um campo 'local' na tabela de utilizadores.
        'departamento_local' => $user->departamento->local ?? '', 
    ]);
}
}