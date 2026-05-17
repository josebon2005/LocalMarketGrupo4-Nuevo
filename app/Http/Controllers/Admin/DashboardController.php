<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Comercio;
use App\Models\Pedido;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalComercios = Comercio::count();
        $totalUsuarios = User::count();
        $comprasTotales = Pedido::count();
        $totalCategorias = Categoria::count();

        return view('admin.dashboard', compact(
            'totalComercios',
            'totalUsuarios',
            'comprasTotales',
            'totalCategorias'
        ));
    }

    public function dashboard()
    {
        return $this->index();
    }

    public function __invoke()
    {
        return $this->index();
    }
}
