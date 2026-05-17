@extends('layouts.admin')
@section('titulo','Inventario')
@section('subtitulo','Control de stock de productos')
@section('contenido')
<div class="mb-6">
    <h3 class="text-xl font-bold text-slate-800">Inventario</h3>
    <p class="text-slate-400 text-sm">Control de entradas y salidas de stock</p>
</div>
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <table class="w-full">
        <thead>
            <tr class="bg-slate-50 border-b border-slate-100">
                <th class="text-left text-xs font-semibold text-slate-400 uppercase px-6 py-4">Producto</th>
                <th class="text-left text-xs font-semibold text-slate-400 uppercase px-6 py-4">Comercio</th>
                <th class="text-left text-xs font-semibold text-slate-400 uppercase px-6 py-4">Stock actual</th>
                <th class="text-right text-xs font-semibold text-slate-400 uppercase px-6 py-4">Movimiento</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($productos as $producto)
            <tr class="hover:bg-slate-50/70 transition" x-data="{ open: false }">
                <td class="px-6 py-4">
                    <p class="text-sm font-semibold text-slate-800">{{ $producto->nombre }}</p>
                    <p class="text-xs text-slate-400">{{ $producto->categoria->nombre ?? '' }}</p>
                </td>
                <td class="px-6 py-4 text-sm text-slate-600">{{ $producto->comercio->nombre ?? '—' }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-bold {{ $producto->stock <= 5 ? 'text-red-600' : ($producto->stock <= 15 ? 'text-orange-500' : 'text-emerald-600') }}">
                            {{ $producto->stock }} uds.
                        </span>
                        @if($producto->stock <= 5)
                            <span class="text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded-full">⚠ Stock bajo</span>
                        @endif
                    </div>
                </td>
                <td class="px-6 py-4">
                    <form action="{{ route('admin.inventario.movimiento', $producto) }}" method="POST" class="flex items-center justify-end gap-2">
                        @csrf
                        <select name="tipo" class="border border-slate-200 rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-brand-500">
                            <option value="entrada">📥 Entrada</option>
                            <option value="salida">📤 Salida</option>
                        </select>
                        <input type="number" name="cantidad" min="1" placeholder="Cant." class="w-20 border border-slate-200 rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-brand-500">
                        <input type="text" name="motivo" placeholder="Motivo" class="w-32 border border-slate-200 rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-brand-500">
                        <button type="submit" class="flex items-center gap-1 bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold px-3 py-2 rounded-lg transition">
                            <i data-lucide="check" class="w-3.5 h-3.5"></i> Registrar
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-16 text-center text-slate-400">No hay productos</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($productos->hasPages())<div class="px-6 py-4 border-t border-slate-100">{{ $productos->links() }}</div>@endif
</div>
@endsection
