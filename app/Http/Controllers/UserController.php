<?php

// Exemplo GPT, não entendi.

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $searchTerm = $request->input('term');
        if (strlen($searchTerm) < 2) { // Opcional: Garante que a pesquisa só ocorra com pelo menos 2 caracteres
            return response()->json([]);
        }

        $users = User::where('name', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
            ->limit(10) // Limite o número de resultados
            ->get(['id', 'name', 'email']);

        // Mapear para o formato que seu Alpine component espera (value/key ou id/text)
        // O seu JS exemplo usa 'value' para o label e 'key' para o ID
        $formattedUsers = $users->mapWithKeys(function ($user) {
            return [$user->id => $user->name . ' (' . $user->email . ')'];
        });

        return response()->json($formattedUsers);
    }

    // ...
    public function show($id)
    {
        $user = User::find($id);
        if ($user) {
            // Retorna o formato esperado para preencher o old() value
            return response()->json([
                'id' => $user->id,
                'value' => $user->name . ' (' . $user->email . ')',
                'name' => $user->name // Se precisar do nome puro para o input
            ]);
        }
        return response()->json(null, 404);
    }
}
