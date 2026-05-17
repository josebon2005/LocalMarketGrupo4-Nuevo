@extends('layouts.admin')
@section('titulo','Nuevo Usuario')
@section('subtitulo','Crear cuenta de usuario')
@section('contenido')
<div class="max-w-2xl">
    <div class="flex items-center gap-2 text-sm text-slate-400 mb-6">
        <a href="{{ route('admin.usuarios.index') }}" class="hover:text-brand-600">Usuarios</a>
        <i data-lucide="chevron-right" class="w-4 h-4"></i>
        <span class="text-slate-600 font-medium">Nuevo usuario</span>
    </div>
    <form action="{{ route('admin.usuarios.store') }}" method="POST" class="space-y-6">
        @csrf
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 space-y-6">
            <div class="flex items-center gap-4 pb-6 border-b border-slate-100">
                <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center">
                    <i data-lucide="user-plus" class="w-6 h-6 text-blue-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Datos del usuario</h3>
                    <p class="text-slate-400 text-sm">Completa la información de la cuenta</p>
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nombre completo <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Nombre completo"
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition @error('name') border-red-400 @enderror">
                @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Correo electrónico <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="correo@ejemplo.com"
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition @error('email') border-red-400 @enderror">
                @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Rol <span class="text-red-500">*</span></label>
                <select name="role" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                    <option value="comprador" {{ old('role') == 'comprador' ? 'selected' : '' }}>Comprador</option>
                    <option value="comerciante" {{ old('role') == 'comerciante' ? 'selected' : '' }}>Comerciante</option>
                    <option value="repartidor" {{ old('role') == 'repartidor' ? 'selected' : '' }}>Repartidor</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                </select>
                @error('role')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Contraseña <span class="text-red-500">*</span></label>
                <input type="password" name="password" placeholder="Mínimo 8 caracteres"
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition @error('password') border-red-400 @enderror">
                @error('password')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Confirmar contraseña <span class="text-red-500">*</span></label>
                <input type="password" name="password_confirmation" placeholder="Repetir contraseña"
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button type="submit" class="flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold text-sm px-6 py-3 rounded-xl transition">
                <i data-lucide="save" class="w-4 h-4"></i> Crear usuario
            </button>
            <a href="{{ route('admin.usuarios.index') }}" class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-sm px-6 py-3 rounded-xl transition">
                <i data-lucide="x" class="w-4 h-4"></i> Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
