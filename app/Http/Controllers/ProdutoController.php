<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
    // GET /produtos
    public function index(Request $request)
    {
        // Filtro por categoria salvo em sessão
        $categoryId = $request->input('category_id', $request->session()->get('filter_category'));

        if ($request->has('category_id')) {
            $request->session()->put('filter_category', $categoryId);
        }

        $products = Produto::with('category')
            ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
            ->orderBy('name')
            ->paginate(10);

        $categories = Categoria::orderBy('name')->get();

        return view('produtos.index', compact('products', 'categories', 'categoryId'));
    }

    // GET /produtos/create
    public function create(Request $request)
    {
        $categories = Categoria::orderBy('name')->get();

        // Última categoria do cookie
        $lastCategory = $request->cookie('last_category');

        return view('produtos.create', compact('categories', 'lastCategory'));
    }

    // POST /produtos
    public function store(Request $request)
{
    $data = $request->validate([
        'category_id' => ['required','exists:categories,id'],
        'name'        => ['required','string','max:150'],
        'price'       => ['required','numeric','min:0'],
        'image'       => ['nullable','image','mimes:jpg,jpeg,png','max:2048'],
        'description' => ['nullable','string','max:2000'],
    ]);

    if ($request->hasFile('image')) {
        $data['image_path'] = $request->file('image')->store('products', 'public');
    }
if ($request->hasFile('image')) {
    $file = $request->file('image');
    dd([
        'exists' => $file->isValid(),
        'originalName' => $file->getClientOriginalName(),
        'size' => $file->getSize(),
    ]);
}
    $produto = Produto::create($data);

    // AQUI sim, $data já existe
    Cookie::queue('last_category', $data['category_id'], 60 * 24 * 30);

    return redirect()->route('produtos.index')
        ->with('success', 'Produto criado com sucesso!');
}


    // GET /produtos/{produto}/edit
    public function edit(Produto $produto)
    {
        $categories = Categoria::orderBy('name')->get();

        return view('produtos.edit', compact('produto', 'categories'));
    }

    // PUT /produtos/{produto}
   public function update(Request $request, Produto $produto)
{
    $data = $request->validate([
        'category_id' => ['required','exists:categories,id'],
        'name'        => ['required','string','max:150'],
        'price'       => ['required','numeric','min:0'],
        'image'       => ['nullable','image','mimes:jpeg,jpg,png','max:2048'],
        'description' => ['nullable','string','max:2000'],
    ]);

    // Troca de imagem
    if ($request->hasFile('image')) {
        if ($produto->image_path) {
            Storage::disk('public')->delete($produto->image_path);
        }

        $data['image_path'] = $request->file('image')->store('products', 'public');
    }

    $produto->update($data);

    // Cookie correto
    Cookie::queue('last_category', $produto->category_id, 60 * 24 * 30);

    return redirect()->route('produtos.index')
        ->with('success', 'Produto atualizado com sucesso!');
}


    // DELETE /produtos/{produto}
    public function destroy(Produto $produto)
    {
        if ($produto->image_path) {
            Storage::disk('public')->delete($produto->image_path);
        }

        $produto->delete();

        return redirect()->route('produtos.index')
            ->with('success', 'Produto excluído com sucesso!');
    }
    
}
