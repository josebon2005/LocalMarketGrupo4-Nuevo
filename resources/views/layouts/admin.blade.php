<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>LocalMarket · @yield('titulo', 'Panel Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81'
                        }
                    }
                }
            }
        }
    </script>

    <style>
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            color: #c7d2fe;
            transition: all .18s;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background: rgba(255, 255, 255, .12);
            color: #fff;
        }

        .sidebar-link.active {
            background: rgba(255, 255, 255, .18);
            box-shadow: inset 3px 0 0 #a5b4fc;
        }

        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,.08), 0 4px 16px rgba(0,0,0,.04);
            transition: transform .2s, box-shadow .2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 24px rgba(0,0,0,.10);
        }
    </style>
</head>

<body class="bg-slate-50 antialiased">
<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-gradient-to-b from-brand-800 to-brand-900 fixed h-full flex flex-col z-30 shadow-xl">
        <div class="px-6 py-5 border-b border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                    <i data-lucide="shopping-bag" class="w-5 h-5 text-white"></i>
                </div>

                <div>
                    <h1 class="text-white font-bold text-lg leading-none">LocalMarket</h1>
                    <p class="text-indigo-300 text-xs mt-0.5">Panel Administrativo</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
            <p class="text-indigo-400 text-xs font-semibold uppercase tracking-wider px-4 py-2">Principal</p>

            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i data-lucide="layout-dashboard" class="w-4 h-4 flex-shrink-0"></i>
                Dashboard
            </a>

            <p class="text-indigo-400 text-xs font-semibold uppercase tracking-wider px-4 py-2 mt-3">Catálogo</p>

            <a href="{{ route('admin.categorias.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.categorias*') ? 'active' : '' }}">
                <i data-lucide="tag" class="w-4 h-4 flex-shrink-0"></i>
                Categorías
            </a>

            <a href="{{ route('admin.productos.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.productos*') ? 'active' : '' }}">
                <i data-lucide="package" class="w-4 h-4 flex-shrink-0"></i>
                Productos
            </a>

            <p class="text-indigo-400 text-xs font-semibold uppercase tracking-wider px-4 py-2 mt-3">Gestión</p>

            <a href="{{ route('admin.comercios.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.comercios*') ? 'active' : '' }}">
                <i data-lucide="store" class="w-4 h-4 flex-shrink-0"></i>
                Comercios
            </a>

            <a href="{{ route('admin.usuarios.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.usuarios*') ? 'active' : '' }}">
                <i data-lucide="users" class="w-4 h-4 flex-shrink-0"></i>
                Usuarios
            </a>

            <a href="{{ route('admin.pedidos.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.pedidos*') ? 'active' : '' }}">
                <i data-lucide="shopping-cart" class="w-4 h-4 flex-shrink-0"></i>
                Pedidos
            </a>

            <a href="{{ route('admin.inventario.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.inventario*') ? 'active' : '' }}">
                <i data-lucide="boxes" class="w-4 h-4 flex-shrink-0"></i>
                Inventario
            </a>

            <p class="text-indigo-400 text-xs font-semibold uppercase tracking-wider px-4 py-2 mt-3">Reportes</p>

            <a href="{{ route('admin.reportes.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.reportes*') ? 'active' : '' }}">
                <i data-lucide="bar-chart-2" class="w-4 h-4 flex-shrink-0"></i>
                Reportes de Ventas
            </a>
        </nav>

        <div class="px-3 py-4 border-t border-white/10">
            <div class="flex items-center gap-3 px-3 py-2">
                <div class="w-8 h-8 rounded-full bg-indigo-400/40 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

                <div class="flex-1 min-w-0">
                    <p class="text-white text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                    <p class="text-indigo-300 text-xs truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="mt-1">
                @csrf
                <button type="submit" class="sidebar-link w-full text-left text-red-300 hover:text-red-200 hover:bg-red-500/10">
                    <i data-lucide="log-out" class="w-4 h-4 flex-shrink-0"></i>
                    Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN --}}
    <div class="ml-64 flex-1 flex flex-col min-h-screen">
        <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between sticky top-0 z-20">
            <div>
                <h2 class="text-lg font-semibold text-slate-800">@yield('titulo', 'Panel Administrativo')</h2>
                <p class="text-slate-400 text-xs">@yield('subtitulo', 'LocalMarket · Panel de administración')</p>
            </div>

            <div class="flex items-center gap-3">
                <button class="relative w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-slate-200 transition">
                    <i data-lucide="bell" class="w-4 h-4"></i>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>

                <div class="flex items-center gap-2 bg-slate-100 rounded-xl px-3 py-1.5">
                    <div class="w-7 h-7 rounded-lg bg-brand-600 flex items-center justify-center text-white font-bold text-xs">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="text-slate-700 text-sm font-medium">{{ auth()->user()->name }}</span>
                </div>
            </div>
        </header>

        <main class="flex-1 p-6">
            @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Listo!',
                            text: "{{ session('success') }}",
                            timer: 2500,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-end'
                        });
                    });
                </script>
            @endif

            @if(session('error'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: "{{ session('error') }}",
                            timer: 3000,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-end'
                        });
                    });
                </script>
            @endif

            @yield('contenido')
        </main>

        <footer class="px-6 py-4 border-t border-slate-200 bg-white">
            <p class="text-slate-400 text-xs text-center">
                LocalMarket © {{ date('Y') }} · Grupo #4 · Panel Administrativo
            </p>
        </footer>
    </div>
</div>

@yield('scripts')

<script>
    lucide.createIcons();
</script>
</body>
</html>
