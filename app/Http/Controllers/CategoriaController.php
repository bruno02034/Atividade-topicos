<?php



namespace App\Http\Controllers;

use App\Models\Categoria;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CategoriaController extends Controller
{
    // GET /categorias
    public function index(Request $request)
    {
        // Termo de busca salvo em sessão
        $search = $request->input('q', $request->session()->get('cat_search'));
        if ($request->has('q')) {
            $request->session()->put('cat_search', $search);
        }

        $categories = Categoria::when($search, fn($q) =>
                $q->where('name', 'like', "%{$search}%")
            )
            ->orderBy('name')
            ->paginate(10);

        // Cookie com a última categoria usada
        $lastCategoryId = $request->cookie('last_category');

        // >>> AQUI: passar $categories, $search, $lastCategoryId
        return view('categorias.index', compact('categories','search','lastCategoryId'));
    }

    // GET /categorias/create
    public function create()
    {
        return view('categorias.create');
    }

    // POST /categorias
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required','string','max:120','unique:categories,name'],
            'description' => ['nullable','string','max:1000'],
        ]);

        $categoria = Categoria::create($data);

        // Atualiza cookie com última categoria
        Cookie::queue('last_category', $categoria->id, 60 * 24 * 30);

        return redirect()->route('categorias.index')->with('success', 'Categoria criada com sucesso!');
    }

    // GET /categorias/{categoria}/edit
   public function edit($id)
{
    $category = Categoria::findOrFail($id);


    return view('categorias.edit', compact('category'));
}


    // PUT/PATCH /categorias/{categoria}
    public function update(Request $request, Categoria $categoria)
    {
        $data = $request->validate([
            'name'        => ['required','string','max:120',"unique:categories,name,{$categoria->id}"],
            'description' => ['nullable','string','max:1000'],
        ]);

        $categoria->update($data);

        Cookie::queue('last_category', $categoria->id, 60 * 24 * 30);

        return redirect()->route('categorias.index')->with('success', 'Categoria atualizada com sucesso!');
    }

    // DELETE /categorias/{categoria}
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        return redirect()->route('categorias.index')->with('success', 'Categoria excluída com sucesso!');
    }
    public function show($id)
{
    // salva cookie por 1 dia
    cookie()->queue('last_category', $id, 60 * 24);

    $category = Categoria::findOrFail($id);
    return view('categorias.show', compact('category'));
}
}
