@extends('layouts.admin')
@section('titulo','Pedidos')
@section('subtitulo','Gestión de pedidos de la plataforma')
@section('contenido')
<div class="flex items-center justify-between mb-6">
    <div>
        <h3 class="text-xl font-bold text-slate-800">Pedidos</h3>
        <p class="text-slate-400 text-sm">{{ $pedidos->total() }} pedidos en total</p>
    </div>
</div>
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <table class="w-full">
        <thead>
            <tr class="bg-slate-50 border-b border-slate-100">
                <th class="text-left text-xs font-semibold text-slate-400 uppercase px-6 py-4">#</th>
                <th class="text-left text-xs font-semibold text-slate-400 uppercase px-6 py-4">Comprador</th>
                <th class="text-left text-xs font-semibold text-slate-400 uppercase px-6 py-4">Comercio</th>
                <th class="text-left text-xs font-semibold text-slate-400 uppercase px-6 py-4">Total</th>
                <th class="text-left text-xs font-semibold text-slate-400 uppercase px-6 py-4">Estado</th>
                <th class="text-left text-xs font-semibold text-slate-400 uppercase px-6 py-4">Fecha</th>
                <th class="text-right text-xs font-semibold text-slate-400 uppercase px-6 py-4">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($pedidos as $pedido)
            @php
                $colores = [
                    'pendiente'  => 'bg-yellow-100 text-yellow-700',
                    'confirmado' => 'bg-blue-100 text-blue-700',
                    'en_camino'  => 'bg-purple-100 text-purple-700',
                    'entregado'  => 'bg-emerald-100 text-emerald-700',
                    'cancelado'  => 'bg-red-100 text-red-700',
                ];
            @endphp
            <tr class="hover:bg-slate-50/70 transition">
                <td class="px-6 py-4"><span class="text-xs font-mono bg-slate-100 text-slate-500 px-2 py-1 rounded-lg">#{{ $pedido->id }}</span></td>
                <td class="px-6 py-4">
                    <p class="text-sm font-semibold text-slate-800">{{ $pedido->comprador->name ?? '—' }}</p>
                    <p class="text-xs text-slate-400">{{ $pedido->comprador->email ?? '' }}</p>
                </td>
                <td class="px-6 py-4 text-sm text-slate-600">{{ $pedido->comercio->nombre ?? '—' }}</td>
                <td class="px-6 py-4 text-sm font-bold text-slate-800">Q{{ number_format($pedido->total, 2) }}</td>
                <td class="px-6 py-4">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $colores[$pedido->estado] ?? 'bg-slate-100 text-slate-600' }}">
                        {{ ucfirst(str_replace('_', ' ', $pedido->estado)) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-slate-500">{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                <td class="px-6 py-4 text-right">
                    <a href="{{ route('admin.pedidos.show', $pedido) }}" class="flex items-center justify-end gap-1.5 text-xs font-semibold text-brand-600 bg-brand-50 hover:bg-brand-100 px-3 py-1.5 rounded-lg transition">
                        <i data-lucide="eye" class="w-3.5 h-3.5"></i> Ver detalle
                    </a>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-6 py-16 text-center text-slate-400">No hay pedidos registrados</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($pedidos->hasPages())<div class="px-6 py-4 border-t border-slate-100">{{ $pedidos->links() }}</div>@endif
</div>
@endsection
