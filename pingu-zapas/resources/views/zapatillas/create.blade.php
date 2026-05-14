@extends('layout.master')

@section('title', 'Nueva zapatilla | Pingu Zapas')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Nueva zapatilla</h1>
            <a href="{{ route('admin.zapatillas.index') }}" class="btn btn-ghost">
                <i class="fas fa-arrow-left"></i> Volver al listado
            </a>
        </div>
        <section class="panel" style="padding: 24px;">
            <form method="POST" action="{{ route('admin.zapatillas.store') }}" class="form-stack" enctype="multipart/form-data">
                @csrf
                @include('zapatillas.partials.form')
            </form>
        </section>
    </div>
@endsection
