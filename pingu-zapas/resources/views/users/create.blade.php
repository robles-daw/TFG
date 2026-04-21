@extends('layout.master')

@section('title', 'Nuevo usuario | Pingu Zapas')

@section('content')
    <div class="container">
        <section class="panel" style="padding: 24px;">
            <h1 class="page-title">Nuevo usuario</h1>
            <form method="POST" action="{{ route('admin.users.store') }}" class="form-stack">
                @csrf
                @include('users.partials.form')
            </form>
        </section>
    </div>
@endsection
