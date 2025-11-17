@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Cadastrar Produto</h1>

    <form action="{{ route('produtos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Categoria --}}
        <div class="mb-3">
            <label class="form-label">Categoria</label>
            <select name="category_id" class="form-select" required>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}"
                        @selected(old('category_id', $lastCategory) == $c->id)>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Nome --}}
        <div class="mb-3">
            <label class="form-label">Nome</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        {{-- Preço --}}
        <div class="mb-3">
            <label class="form-label">Preço</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>

        {{-- Descrição --}}
        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        {{-- Imagem --}}
        <div class="mb-3">
            <label class="form-label">Imagem (PNG/JPG)</label>
            <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png">
        </div>

        <button class="btn btn-primary">Salvar</button>
    </form>

</div>
@endsection
