@extends('layout.master')

@section('title', 'Editar descuento | Pingu Zapas')

@section('content')
    <div class="container">
        <section class="panel" style="padding: 24px;">
            <h1 class="page-title">Editar descuento</h1>
            <form method="POST" action="{{ route('admin.descuentos.update', $descuento) }}" class="form-stack">
                @csrf
                @method('PUT')
                @include('descuentos.partials.form', ['descuento' => $descuento])
            </form>
        </section>
    </div>
@endsection
