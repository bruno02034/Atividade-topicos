@extends('layouts.app')

@section('title', 'Editar Categoria')

@section('content')
<div class="card">
  <div class="card-body">

    <form action="{{ route('categorias.update', $category->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label class="form-label">Nome</label>
        <input class="form-control" name="name" value="{{ old('name', $category->name) }}">
      </div>

      <div class="mb-3">
        <label class="form-label">Descrição</label>
        <textarea class="form-control" name="description">{{ old('description', $category->description) }}</textarea>
      </div>

      <button class="btn btn-primary">Atualizar</button>
      <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Voltar</a>
    </form>

  </div>
</div>
@endsection
