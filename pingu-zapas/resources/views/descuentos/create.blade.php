@extends('layout.master')

@section('title', 'Nuevo descuento | Pingu Zapas')

@section('content')
    <div class="container">
        <section class="panel" style="padding: 24px;">
            <h1 class="page-title">Nuevo descuento</h1>
            <form method="POST" action="{{ route('admin.descuentos.store') }}" class="form-stack">
                @csrf
                @include('descuentos.partials.form')
            </form>
        </section>
    </div>
@endsection
