@extends('layouts.app')
@section('title','Categorias')
@section('content')

<form method="GET" class="row g-2 mb-3">
    <div class="col-auto">
        <input type="text" name="q" class="form-control" placeholder="Buscar..." value="{{ $search }}">
    </div>
    <div class="col-auto">
        <button class="btn btn-outline-secondary">Filtrar</button>
    </div>
    <div class="col-auto ms-auto">
        <a href="{{ route('categorias.create') }}" class="btn btn-primary">+ Nova Categoria</a>
    </div>
</form>

@if($lastCategoryId)
    <div class="alert alert-info">
        Última categoria acessada (cookie): ID {{ $lastCategoryId }}
    </div>
@endif

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $c)
            <tr>
                <td>{{ $c->id }}</td>
                <td>{{ $c->name }}</td>
                <td class="text-nowrap">
                    <a href="{{ route('categorias.edit', $c->id) }}" class="btn btn-sm btn-primary">Editar</a>
                    <form action="{{ route('categorias.destroy', $c->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Excluir?')">Excluir</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3">Nenhuma categoria cadastrada.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $categories->withQueryString()->links() }}
@endsection
