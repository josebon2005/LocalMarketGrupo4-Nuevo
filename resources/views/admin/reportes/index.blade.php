@extends('layouts.admin')
@section('titulo','Reportes de Ventas')
@section('subtitulo','Análisis de ventas por período')
@section('contenido')

{{-- Filtros --}}
<form method="GET" action="{{ route('admin.reportes.index') }}" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
    <div class="flex items-end gap-4">
        <div class="flex-1">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Desde</label>
            <input type="date" name="desde" value="{{ $desde }}" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
        </div>
        <div class="flex-1">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Hasta</label>
            <input type="date" name="hasta" value="{{ $hasta }}" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
        </div>
        <button type="submit" class="flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold text-sm px-5 py-3 rounded-xl transition">
            <i data-lucide="search" class="w-4 h-4"></i> Filtrar
        </button>
        <a href="{{ route('admin.reportes.exportar', request()->query()) }}" class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm px-5 py-3 rounded-xl transition">
            <i data-lucide="download" class="w-4 h-4"></i> Exportar CSV
        </a>
    </div>
</form>

{{-- Stats --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                <i data-lucide="trending-up" class="w-6 h-6 text-emerald-600"></i>
            </div>
            <div>
                <p class="text-sm text-slate-500">Total ventas (entregados)</p>
                <p class="text-2xl font-bold text-slate-800">Q{{ number_format($totalVentas, 2) }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i data-lucide="shopping-cart" class="w-6 h-6 text-blue-600"></i>
            </div>
            <div>
                <p class="text-sm text-slate-500">Total pedidos</p>
                <p class="text-2xl font-bold text-slate-800">{{ $totalPedidos }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
    {{-- Pedidos por estado --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h3 class="text-base font-bold text-slate-800 mb-4">Pedidos por estado</h3>
        @php $colores = ['pendiente'=>'bg-yellow-100 text-yellow-700','confirmado'=>'bg-blue-100 text-blue-700','en_camino'=>'bg-purple-100 text-purple-700','entregado'=>'bg-emerald-100 text-emerald-700','cancelado'=>'bg-red-100 text-red-700']; @endphp
        <div class="space-y-3">
            @forelse($pedidosPorEstado as $item)
            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $colores[$item->estado] ?? 'bg-slate-100 text-slate-600' }}">
                    {{ ucfirst(str_replace('_', ' ', $item->estado)) }}
                </span>
                <span class="text-sm font-bold text-slate-800">{{ $item->total }} pedidos</span>
            </div>
            @empty
            <p class="text-sm text-slate-400 text-center py-4">Sin datos en este período</p>
            @endforelse
        </div>
    </div>

    {{-- Ventas por comercio --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h3 class="text-base font-bold text-slate-800 mb-4">Ventas por comercio</h3>
        <div class="space-y-3">
            @forelse($ventasPorComercio as $item)
            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                <div>
                    <p class="text-sm font-semibold text-slate-800">{{ $item->comercio->nombre ?? '—' }}</p>
                    <p class="text-xs text-slate-400">{{ $item->pedidos }} pedidos</p>
                </div>
                <span class="text-sm font-bold text-emerald-600">Q{{ number_format($item->total_ventas, 2) }}</span>
            </div>
            @empty
            <p class="text-sm text-slate-400 text-center py-4">Sin ventas en este período</p>
            @endforelse
        </div>
    </div>

    {{-- Productos más vendidos --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 xl:col-span-2">
        <h3 class="text-base font-bold text-slate-800 mb-4">Productos más vendidos</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="text-left text-xs font-semibold text-slate-400 uppercase py-2">#</th>
                        <th class="text-left text-xs font-semibold text-slate-400 uppercase py-2">Producto</th>
                        <th class="text-left text-xs font-semibold text-slate-400 uppercase py-2">Unidades</th>
                        <th class="text-left text-xs font-semibold text-slate-400 uppercase py-2">Ingresos</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($productosMasVendidos as $i => $item)
                    <tr>
                        <td class="py-3 text-sm text-slate-400">{{ $i + 1 }}</td>
                        <td class="py-3 text-sm font-semibold text-slate-800">{{ $item->producto->nombre ?? '—' }}</td>
                        <td class="py-3 text-sm text-slate-600">{{ $item->total_vendido }} uds.</td>
                        <td class="py-3 text-sm font-bold text-emerald-600">Q{{ number_format($item->total_ingresos, 2) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="py-8 text-center text-slate-400">Sin datos</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
