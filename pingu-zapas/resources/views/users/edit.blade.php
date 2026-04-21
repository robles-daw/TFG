@extends('layout.master')

@section('title', 'Editar usuario | Pingu Zapas')

@section('content')
    <div class="container">
        <section class="panel" style="padding: 24px;">
            <h1 class="page-title">Editar usuario</h1>
            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="form-stack">
                @csrf
                @method('PUT')
                @include('users.partials.form', ['user' => $user])
            </form>
        </section>
    </div>
@endsection
