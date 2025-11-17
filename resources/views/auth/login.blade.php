@extends('layouts.app')
@section('title','Login')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">Login (demo)</div>
      <div class="card-body">
        {{ route(
          @csrf
          <div class="mb-3">
            <label class="form-label">E-mail</label>
            <input type="email" class="form-control" name="email" value="{{ old('email','admin@example.com') }}">
          </div>
          <div class="mb-3">
            <label class="form-label">Senha</label>
            <input type="password" class="form-control" name="password" value="admin">
          </div>
          <button class="btn btn-primary w-100">Entrar</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection