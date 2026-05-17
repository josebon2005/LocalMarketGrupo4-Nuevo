@extends('layouts.admin')

@section('titulo', 'Dashboard')
@section('subtitulo', 'Resumen general de LocalMarket')

@section('contenido')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Dashboard Administrativo</h1>
        <p class="text-slate-500 mt-1">Resumen general del sistema LocalMarket</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">Comercios creados</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalComercios }}</h3>
                </div>

                <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center">
                    <i data-lucide="store" class="w-6 h-6 text-indigo-600"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">Usuarios registrados</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalUsuarios }}</h3>
                </div>

                <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center">
                    <i data-lucide="users" class="w-6 h-6 text-indigo-600"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">Compras totales</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $comprasTotales }}</h3>
                </div>

                <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center">
                    <i data-lucide="shopping-cart" class="w-6 h-6 text-indigo-600"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">Categorías</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalCategorias }}</h3>
                </div>

                <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center">
                    <i data-lucide="tag" class="w-6 h-6 text-indigo-600"></i>
                </div>
            </div>
        </div>

    </div>

    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="text-lg font-semibold text-slate-800 mb-2">Panel de control</h2>
        <p class="text-slate-500">
            Desde este panel puedes visualizar el resumen general del sistema:
            comercios creados, usuarios registrados, compras realizadas y categorías disponibles.
        </p>
    </div>
@endsection
