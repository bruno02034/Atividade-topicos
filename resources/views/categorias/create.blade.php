@extends('layouts.app')

@section('title', 'Nova Categoria')

@section('content')
<div class="card">
  <div class="card-body">

    <form action="{{ route('categorias.store') }}" method="POST">
      @csrf

      <div class="mb-3">
        <label class="form-label">Nome</label>
        <input class="form-control" name="name" value="{{ old('name') }}">
      </div>

      <div class="mb-3">
        <label class="form-label">Descrição</label>
        <textarea class="form-control" name="description">{{ old('description') }}</textarea>
      </div>

      <button class="btn btn-primary">Salvar</button>
      <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Voltar</a>

    </form>

  </div>
</div>
@endsection
