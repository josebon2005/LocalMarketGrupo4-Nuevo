@extends('layouts.admin')
@section('titulo','Usuarios')
@section('subtitulo','Gestión de usuarios de la plataforma')
@section('contenido')
<div class="flex items-center justify-between mb-6">
    <div>
        <h3 class="text-xl font-bold text-slate-800">Usuarios</h3>
        <p class="text-slate-400 text-sm">{{ $usuarios->total() }} usuarios registrados</p>
    </div>
    <a href="{{ route('admin.usuarios.create') }}" class="flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition">
        <i data-lucide="plus" class="w-4 h-4"></i> Nuevo usuario
    </a>
</div>
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <table class="w-full">
        <thead>
            <tr class="bg-slate-50 border-b border-slate-100">
                <th class="text-left text-xs font-semibold text-slate-400 uppercase px-6 py-4">Usuario</th>
                <th class="text-left text-xs font-semibold text-slate-400 uppercase px-6 py-4">Email</th>
                <th class="text-left text-xs font-semibold text-slate-400 uppercase px-6 py-4">Rol</th>
                <th class="text-left text-xs font-semibold text-slate-400 uppercase px-6 py-4">Registrado</th>
                <th class="text-right text-xs font-semibold text-slate-400 uppercase px-6 py-4">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($usuarios as $u)
            <tr class="hover:bg-slate-50/70 transition">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-brand-100 flex items-center justify-center text-brand-700 font-bold text-sm flex-shrink-0">
                            {{ strtoupper(substr($u->name, 0, 1)) }}
                        </div>
                        <p class="text-sm font-semibold text-slate-800">{{ $u->name }}</p>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-slate-600">{{ $u->email }}</td>
                <td class="px-6 py-4">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $u->role->color() }}">
                        {{ $u->role->label() }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-slate-500">{{ $u->created_at->format('d/m/Y') }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.usuarios.edit', $u) }}" class="flex items-center gap-1.5 text-xs font-semibold text-brand-600 bg-brand-50 hover:bg-brand-100 px-3 py-1.5 rounded-lg transition">
                            <i data-lucide="pencil" class="w-3.5 h-3.5"></i> Editar
                        </a>
                        @if($u->id !== auth()->id())
                        <form action="{{ route('admin.usuarios.destroy', $u) }}" method="POST" class="delete-form">
                            @csrf @method('DELETE')
                            <button class="flex items-center gap-1.5 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Eliminar
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-16 text-center text-slate-400">No hay usuarios</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($usuarios->hasPages())<div class="px-6 py-4 border-t border-slate-100">{{ $usuarios->links() }}</div>@endif
</div>
@endsection
@section('scripts')
<script>
document.querySelectorAll('.delete-form').forEach(f => {
    f.addEventListener('submit', e => { e.preventDefault();
        Swal.fire({title:'¿Eliminar usuario?',icon:'warning',showCancelButton:true,confirmButtonColor:'#ef4444',cancelButtonColor:'#6b7280',confirmButtonText:'Sí, eliminar',cancelButtonText:'Cancelar'}).then(r => { if(r.isConfirmed) f.submit(); });
    });
});
</script>
@endsection
