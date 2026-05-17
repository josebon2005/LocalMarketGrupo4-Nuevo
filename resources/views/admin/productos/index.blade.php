@extends('layouts.admin')
@section('titulo','Productos')
@section('subtitulo','Gestión global de productos')
@section('contenido')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Productos</h3>
            <p class="text-slate-400 text-sm">{{ $productos->total() }} productos registrados</p>
        </div>
        <a href="{{ route('admin.productos.create') }}" class="flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition">
            <i data-lucide="plus" class="w-4 h-4"></i> Nuevo producto
        </a>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full">
            <thead>
            <tr class="bg-slate-50 border-b border-slate-100">
                <th class="text-left text-xs font-semibold text-slate-400 uppercase px-6 py-4">Producto</th>
                <th class="text-left text-xs font-semibold text-slate-400 uppercase px-6 py-4">Comercio</th>
                <th class="text-left text-xs font-semibold text-slate-400 uppercase px-6 py-4">Categoría</th>
                <th class="text-left text-xs font-semibold text-slate-400 uppercase px-6 py-4">Precio</th>
                <th class="text-left text-xs font-semibold text-slate-400 uppercase px-6 py-4">Stock</th>
                <th class="text-right text-xs font-semibold text-slate-400 uppercase px-6 py-4">Acciones</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse($productos as $p)
                <tr class="hover:bg-slate-50/70 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0 flex items-center justify-center">
                                @if($p->imagen)
                                    <img src="{{ asset('storage/'.$p->imagen) }}" class="w-full h-full object-cover">
                                @else
                                    <i data-lucide="package" class="w-5 h-5 text-slate-400"></i>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-800">{{ $p->nombre }}</p>
                                <span class="text-xs {{ $p->activo ? 'text-emerald-600' : 'text-red-500' }}">{{ $p->activo ? '● Activo' : '● Inactivo' }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">{{ $p->comercio->nombre ?? '—' }}</td>
                    <td class="px-6 py-4"><span class="text-xs bg-brand-50 text-brand-700 font-semibold px-2 py-1 rounded-full">{{ $p->categoria->icono ?? '' }} {{ $p->categoria->nombre ?? '—' }}</span></td>
                    <td class="px-6 py-4 text-sm font-bold text-slate-800">Q{{ number_format($p->precio, 2) }}</td>
                    <td class="px-6 py-4">
                    <span class="text-sm font-semibold {{ $p->stock <= 5 ? 'text-red-600' : 'text-slate-700' }}">
                        {{ $p->stock }} @if($p->stock <= 5)<span class="text-xs bg-red-100 text-red-600 px-1.5 py-0.5 rounded-full ml-1">Bajo</span>@endif
                    </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.productos.edit', $p) }}" class="flex items-center gap-1.5 text-xs font-semibold text-brand-600 bg-brand-50 hover:bg-brand-100 px-3 py-1.5 rounded-lg transition">
                                <i data-lucide="pencil" class="w-3.5 h-3.5"></i> Editar
                            </a>
                            <form action="{{ route('admin.productos.destroy', $p) }}" method="POST" class="delete-form">
                                @csrf @method('DELETE')
                                <button class="flex items-center gap-1.5 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition">
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-6 py-16 text-center text-slate-400">No hay productos registrados</td></tr>
            @endforelse
            </tbody>
        </table>
        @if($productos->hasPages())<div class="px-6 py-4 border-t border-slate-100">{{ $productos->links() }}</div>@endif
    </div>
@endsection
@section('scripts')
    <script>
        document.querySelectorAll('.delete-form').forEach(f => {
            f.addEventListener('submit', e => { e.preventDefault();
                Swal.fire({title:'¿Eliminar producto?',icon:'warning',showCancelButton:true,confirmButtonColor:'#ef4444',cancelButtonColor:'#6b7280',confirmButtonText:'Sí, eliminar',cancelButtonText:'Cancelar'}).then(r => { if(r.isConfirmed) f.submit(); });
            });
        });
    </script>
@endsection
