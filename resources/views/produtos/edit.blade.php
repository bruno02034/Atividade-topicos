@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Editar Produto</h1>

    <form action="{{ route('produtos.update', $produto->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Categoria --}}
        <div class="mb-3">
            <label class="form-label">Categoria</label>
            <select name="category_id" class="form-select" required>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" @selected($produto->category_id == $c->id)>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Nome --}}
        <div class="mb-3">
            <label class="form-label">Nome</label>
            <input type="text" name="name" class="form-control" value="{{ $produto->name }}" required>
        </div>

        {{-- Preço --}}
        <div class="mb-3">
            <label class="form-label">Preço</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ $produto->price }}" required>
        </div>

        {{-- Descrição --}}
        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea name="description" class="form-control">{{ $produto->description }}</textarea>
        </div>

        {{-- Imagem --}}
        <div class="mb-3">
            <label class="form-label">Trocar Imagem (PNG/JPG)</label>
            <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png">

            @if($produto->image_path)
                <div class="mt-2">
                    <strong>Atual:</strong><br>
                    <img src="{{ asset('storage/'.$produto->image_path) }}" width="120" class="img-thumbnail">
                </div>
            @endif
        </div>

        <button class="btn btn-primary">Atualizar</button>
    </form>

</div>
@endsection
