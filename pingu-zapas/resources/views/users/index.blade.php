@extends('layout.master')

@section('title', 'Usuarios | Pingu Zapas')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Usuarios</h1>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Nuevo usuario</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Pedidos</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <div style="display: flex; gap: 10px; align-items: center;">
                                    <div style="width: 32px; height: 32px; background: var(--line); border-radius: 50%; display: grid; place-items: center; font-weight: 700; color: var(--muted);">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <strong>{{ $user->name }}</strong>
                                </div>
                            </td>
                            <td><span class="muted">{{ $user->email }}</span></td>
                            <td>
                                <span class="badge" style="background: {{ $user->rol === 'admin' ? 'rgba(255, 107, 53, 0.1)' : 'rgba(255, 255, 255, 0.05)' }}; color: {{ $user->rol === 'admin' ? 'var(--accent)' : 'var(--text)' }};">
                                    {{ ucfirst($user->rol) }}
                                </span>
                            </td>
                            <td><span class="badge">{{ $user->pedidos_count }} pedidos</span></td>
                            <td>
                                <div class="admin-actions">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-ghost" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('¿Estás seguro?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-ghost" type="submit" title="Eliminar" style="color: var(--danger);">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination">{{ $users->links() }}</div>
    </div>
@endsection
