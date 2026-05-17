@extends('layouts.admin')
@section('titulo','Editar Usuario')
@section('subtitulo','Modificar datos del usuario')
@section('contenido')
<div class="max-w-2xl">
    <div class="flex items-center gap-2 text-sm text-slate-400 mb-6">
        <a href="{{ route('admin.usuarios.index') }}" class="hover:text-brand-600">Usuarios</a>
        <i data-lucide="chevron-right" class="w-4 h-4"></i>
        <span class="text-slate-600 font-medium">{{ $usuario->name }}</span>
    </div>
    <form action="{{ route('admin.usuarios.update', $usuario) }}" method="POST" class="space-y-6">
        @csrf @method('PUT')
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 space-y-6">
            <div class="flex items-center gap-4 pb-6 border-b border-slate-100">
                <div class="w-12 h-12 bg-brand-100 rounded-2xl flex items-center justify-center text-brand-700 font-bold text-xl">
                    {{ strtoupper(substr($usuario->name, 0, 1)) }}
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">{{ $usuario->name }}</h3>
                    <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $usuario->role->color() }}">{{ $usuario->role->label() }}</span>
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nombre completo</label>
                <input type="text" name="name" value="{{ old('name', $usuario->name) }}"
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Correo electrónico</label>
                <input type="email" name="email" value="{{ old('email', $usuario->email) }}"
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Rol</label>
                <select name="role" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                    <option value="comprador" {{ old('role', $usuario->role->value) == 'comprador' ? 'selected' : '' }}>Comprador</option>
                    <option value="comerciante" {{ old('role', $usuario->role->value) == 'comerciante' ? 'selected' : '' }}>Comerciante</option>
                    <option value="repartidor" {{ old('role', $usuario->role->value) == 'repartidor' ? 'selected' : '' }}>Repartidor</option>
                    <option value="admin" {{ old('role', $usuario->role->value) == 'admin' ? 'selected' : '' }}>Administrador</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nueva contraseña <span class="text-slate-400 font-normal">(dejar vacío para no cambiar)</span></label>
                <input type="password" name="password" placeholder="Nueva contraseña"
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" placeholder="Repetir contraseña"
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button type="submit" class="flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold text-sm px-6 py-3 rounded-xl transition">
                <i data-lucide="save" class="w-4 h-4"></i> Guardar cambios
            </button>
            <a href="{{ route('admin.usuarios.index') }}" class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-sm px-6 py-3 rounded-xl transition">
                <i data-lucide="x" class="w-4 h-4"></i> Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
