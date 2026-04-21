@extends('layout.master')

@section('title', 'Editar noticia | Pingu Zapas')

@section('content')
    <div class="container">
        <section class="panel" style="padding: 24px;">
            <h1 class="page-title">Editar noticia</h1>
            <form method="POST" action="{{ route('admin.noticias.update', $noticia) }}" class="form-stack" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('noticias.partials.form', ['noticia' => $noticia])
            </form>
        </section>
    </div>
@endsection
