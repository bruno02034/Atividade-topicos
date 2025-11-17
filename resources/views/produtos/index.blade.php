@extends('layouts.app')
@section('title','Produtos')
@section('content')

<form method="GET" class="row g-2 mb-3">
  <div class="col-auto">
    <select name="category_id" class="form-select" onchange="this.form.submit()">
      <option value="">-- Todas categorias --</option>
      @foreach($categories as $cat)
        <option value="{{ $cat->id }}" @selected($categoryId == $cat->id)>{{ $cat->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-auto ms-auto">
   <a href="{{ route('produtos.create') }}" class="btn btn-primary">+ Novo Produto</a>

  </div>
</form>

<table class="table table-hover align-middle">
  <thead><tr><th>Imagem</th><th>Nome</th><th>Categoria</th><th>Preço</th><th>Ações</th></tr></thead>
  <tbody>
  @forelse($products as $p)
    <tr>
      <td style="width:120px">
        @if($p->image_path)
          {{ asset(image_path) }}" alt="" class="img-thumbnail" style="max-width:100px">
        @endif
      </td>
      <td>{{ $p->name }}</td>
      <td>{{ $p->category->name }}</td>
      <td>R$ {{ number_format($p->price,2,',','.') }}</td>
      <td class="text-nowrap">
      <td class="text-nowrap">
    <a href="{{ route('produtos.edit', $p->id) }}" class="btn btn-sm btn-warning">Editar</a>

    <form action="{{ route('produtos.destroy', $p->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger" onclick="return confirm('Excluir?')">Excluir</button>
        @if($p->image_path)
    <img src="{{ asset('storage/'.$p->image_path) }}" style="max-width: 80px;">
@endif
    </form>
</td>

        </form>
      </td>
    </tr>
  @empty
    <tr><td colspan="5">Nenhum produto cadastrado.</td></tr>
  @endforelse
  </tbody>
</table>

{{ $products->withQueryString()->links() }}
@endsection