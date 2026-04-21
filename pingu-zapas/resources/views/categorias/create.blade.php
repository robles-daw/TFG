@extends('layout.master')

@section('title', 'Nueva categoria | Pingu Zapas')

@section('content')
    <div class="container">
        <div class="page-header"><h1 class="page-title">Nueva categoria</h1></div>
        <section class="panel" style="padding: 24px;">
            <h1 class="page-title">Nueva categoría</h1>
            <form method="POST" action="{{ route('admin.categorias.store') }}" class="form-stack" enctype="multipart/form-data">
                @csrf
                @include('categorias.partials.form')
            </form>
        </section>
    </div>
@endsection
