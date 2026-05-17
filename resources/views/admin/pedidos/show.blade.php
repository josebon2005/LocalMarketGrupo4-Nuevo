@extends('layouts.admin')
@section('titulo','Pedido #{{ $pedido->id }}')
@section('subtitulo','Detalle del pedido')
@section('contenido')
@php
    $colores = ['pendiente'=>'bg-yellow-100 text-yellow-700','confirmado'=>'bg-blue-100 text-blue-700','en_camino'=>'bg-purple-100 text-purple-700','entregado'=>'bg-emerald-100 text-emerald-700','cancelado'=>'bg-red-100 text-red-700'];
@endphp
<div class="flex items-center gap-2 text-sm text-slate-400 mb-6">
    <a href="{{ route('admin.pedidos.index') }}" class="hover:text-brand-600">Pedidos</a>
    <i data-lucide="chevron-right" class="w-4 h-4"></i>
    <span class="text-slate-600 font-medium">Pedido #{{ $pedido->id }}</span>
</div>
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    <div class="xl:col-span-2 space-y-6">
        {{-- Productos del pedido --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-base font-bold text-slate-800 mb-4">Productos del pedido</h3>
            <div class="space-y-3">
                @foreach($pedido->detalles as $detalle)
                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center border border-slate-200 overflow-hidden">
                            @if($detalle->producto->imagen)
                                <img src="{{ asset('storage/'.$detalle->producto->imagen) }}" class="w-full h-full object-cover">
                            @else
                                <i data-lucide="package" class="w-5 h-5 text-slate-400"></i>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">{{ $detalle->producto->nombre ?? '—' }}</p>
                            <p class="text-xs text-slate-400">{{ $detalle->cantidad }} × Q{{ number_format($detalle->precio_unitario, 2) }}</p>
                        </div>
                    </div>
                    <span class="text-sm font-bold text-slate-800">Q{{ number_format($detalle->subtotal, 2) }}</span>
                </div>
                @endforeach
            </div>
            <div class="flex items-center justify-between mt-4 pt-4 border-t border-slate-200">
                <span class="font-bold text-slate-700">Total</span>
                <span class="text-xl font-bold text-brand-600">Q{{ number_format($pedido->total, 2) }}</span>
            </div>
        </div>

        {{-- Actualizar estado --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-base font-bold text-slate-800 mb-4">Actualizar estado</h3>
            <form action="{{ route('admin.pedidos.estado', $pedido) }}" method="POST" class="flex items-center gap-3">
                @csrf @method('PUT')
                <select name="estado" class="flex-1 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                    @foreach(['pendiente','confirmado','en_camino','entregado','cancelado'] as $estado)
                    <option value="{{ $estado }}" {{ $pedido->estado === $estado ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $estado)) }}
                    </option>
                    @endforeach
                </select>
                <button type="submit" class="flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold text-sm px-5 py-3 rounded-xl transition">
                    <i data-lucide="check" class="w-4 h-4"></i> Actualizar
                </button>
            </form>
        </div>
    </div>

    {{-- Sidebar info --}}
    <div class="space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-base font-bold text-slate-800 mb-4">Información del pedido</h3>
            <div class="space-y-3">
                <div class="flex justify-between"><span class="text-sm text-slate-500">Estado</span>
                    <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $colores[$pedido->estado] ?? '' }}">{{ ucfirst(str_replace('_', ' ', $pedido->estado)) }}</span>
                </div>
                <div class="flex justify-between"><span class="text-sm text-slate-500">Fecha</span><span class="text-sm font-semibold text-slate-700">{{ $pedido->created_at->format('d/m/Y H:i') }}</span></div>
                <div class="flex justify-between"><span class="text-sm text-slate-500">Dirección</span><span class="text-sm font-semibold text-slate-700 text-right max-w-[160px]">{{ $pedido->direccion_entrega }}</span></div>
                @if($pedido->notas)
                <div><span class="text-sm text-slate-500">Notas</span><p class="text-sm text-slate-700 mt-1">{{ $pedido->notas }}</p></div>
                @endif
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-base font-bold text-slate-800 mb-4">Comprador</h3>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-brand-100 rounded-xl flex items-center justify-center text-brand-700 font-bold">{{ strtoupper(substr($pedido->comprador->name ?? 'U', 0, 1)) }}</div>
                <div>
                    <p class="text-sm font-semibold text-slate-800">{{ $pedido->comprador->name ?? '—' }}</p>
                    <p class="text-xs text-slate-400">{{ $pedido->comprador->email ?? '' }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-base font-bold text-slate-800 mb-4">Comercio</h3>
            <p class="text-sm font-semibold text-slate-800">{{ $pedido->comercio->nombre ?? '—' }}</p>
            <p class="text-xs text-slate-400">{{ $pedido->comercio->telefono ?? '' }}</p>
        </div>
    </div>
</div>
@endsection
