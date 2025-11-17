<?php


use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Facades\Cookie;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        // Exemplo de uso de sessão: lembrar termo de busca
        $search = $request->input('q', $request->session()->get('cat_search'));
        if ($request->has('q')) {
            $request->session()->put('cat_search', $search);
        }

        $categories = Category::when($search, fn($q) =>
            $q->where('name','like',"%{$search}%")
        )->orderBy('name')->paginate(10);

        // Se existe cookie com última categoria, passamos para a view
        $lastCategoryId = $request->cookie('last_category');

        return view('categories.index', compact('categories','search','lastCategoryId'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());

        // Define cookie "last_category" por 30 dias
        Cookie::queue('last_category', $category->id, 60 * 24 * 30);

        return redirect()->route('categories.index')
            ->with('success', 'Categoria criada com sucesso!');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        Cookie::queue('last_category', $category->id, 60 * 24 * 30);

        return redirect()->route('categories.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Categoria excluída com sucesso!');
    }
}
