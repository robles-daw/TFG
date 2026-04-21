@extends('layout.master')

@section('title', 'Nueva zapatilla | Pingu Zapas')

@section('content')
    <div class="container">
        <div class="page-header"><h1 class="page-title">Nueva zapatilla</h1></div>
        <section class="panel" style="padding: 24px;">
            <form method="POST" action="{{ route('admin.zapatillas.store') }}" class="form-stack" enctype="multipart/form-data">
                @csrf
                @include('zapatillas.partials.form')
            </form>
        </section>
    </div>
@endsection
