<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cookie;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        // Filtro por categoria salvo em SESSÃO
        $categoryId = $request->input('category_id', $request->session()->get('filter_category'));

        if ($request->has('category_id')) {
            $request->session()->put('filter_category', $categoryId);
        }

        $products = Product::with('category')
            ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
            ->orderBy('name')
            ->paginate(10);

        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products','categories','categoryId'));
    }

    public function create(Request $request)
    {
        $categories = Category::orderBy('name')->get();

        // Pré‑seleciona a última categoria (COOKIE), se houver
        $lastCategory = $request->cookie('last_category');

        return view('products.create', compact('categories','lastCategory'));
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            // salva no disco 'public' em 'products'
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($data);

        // Atualiza cookie com última categoria usada
        Cookie::queue('last_category', $product->category_id, 60 * 24 * 30);

        return redirect()->route('products.index')
            ->with('success', 'Produto criado com sucesso!');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('products.edit', compact('product','categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        Cookie::queue('last_category', $product->category_id, 60 * 24 * 30);

        return redirect()->route('products.index')
            ->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Product $product)
    {
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produto excluído com sucesso!');
    }
}
