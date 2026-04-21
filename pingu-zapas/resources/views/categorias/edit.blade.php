@extends('layout.master')

@section('title', 'Editar categoria | Pingu Zapas')

@section('content')
    <div class="container">
        <div class="page-header"><h1 class="page-title">Editar categoria</h1></div>
        <section class="panel" style="padding: 24px;">
            <div class="page-header"><h1 class="page-title">Editar categoría</h1></div>
            <form method="POST" action="{{ route('admin.categorias.update', $categoria) }}" class="form-stack" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('categorias.partials.form', ['categoria' => $categoria])
            </form>
        </section>
    </div>
@endsection
