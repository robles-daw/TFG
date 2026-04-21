@extends('layout.master')

@section('title', 'Nueva noticia | Pingu Zapas')

@section('content')
    <div class="container">
        <section class="panel" style="padding: 24px;">
            <h1 class="page-title">Nueva noticia</h1>
            <form method="POST" action="{{ route('admin.noticias.store') }}" class="form-stack" enctype="multipart/form-data">
                @csrf
                @include('noticias.partials.form')
            </form>
        </section>
    </div>
@endsection
