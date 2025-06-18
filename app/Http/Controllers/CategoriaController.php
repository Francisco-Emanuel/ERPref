<?php
namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::withCount('chamados')->orderBy('nome_amigavel')->paginate(10);
        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome_amigavel' => 'required|string|max:100|unique:categorias,nome_amigavel',
            'tipo_interno' => 'nullable|string|max:100',
        ]);
        Categoria::create($validatedData);
        return redirect()->route('categorias.index')->with('success', 'Categoria criada com sucesso!');
    }

    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $validatedData = $request->validate([
            'nome_amigavel' => ['required', 'string', 'max:100', Rule::unique('categorias')->ignore($categoria->id)],
            'tipo_interno' => 'nullable|string|max:100',
        ]);
        $categoria->update($validatedData);
        return redirect()->route('categorias.index')->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy(Categoria $categoria)
    {
        if ($categoria->chamados()->count() > 0) {
            return redirect()->route('categorias.index')->with('error', 'Não é possível excluir esta categoria, pois ela está sendo usada em chamados.');
        }
        $categoria->delete();
        return redirect()->route('categorias.index')->with('success', 'Categoria excluída com sucesso!');
    }
}