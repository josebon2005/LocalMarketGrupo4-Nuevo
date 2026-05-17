<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\Comercio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        $desde  = $request->get('desde', now()->startOfMonth()->format('Y-m-d'));
        $hasta  = $request->get('hasta', now()->format('Y-m-d'));

        $totalVentas = Pedido::whereBetween('created_at', [$desde, $hasta.' 23:59:59'])
            ->where('estado', 'entregado')->sum('total');

        $totalPedidos = Pedido::whereBetween('created_at', [$desde, $hasta.' 23:59:59'])->count();

        $pedidosPorEstado = Pedido::whereBetween('created_at', [$desde, $hasta.' 23:59:59'])
            ->select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')->get();

        $productosMasVendidos = PedidoDetalle::select(
                'producto_id',
                DB::raw('SUM(cantidad) as total_vendido'),
                DB::raw('SUM(subtotal) as total_ingresos')
            )
            ->with('producto')
            ->whereHas('pedido', fn($q) => $q->whereBetween('created_at', [$desde, $hasta.' 23:59:59']))
            ->groupBy('producto_id')
            ->orderByDesc('total_vendido')
            ->limit(10)->get();

        $ventasPorComercio = Pedido::whereBetween('created_at', [$desde, $hasta.' 23:59:59'])
            ->where('estado', 'entregado')
            ->select('comercio_id', DB::raw('SUM(total) as total_ventas'), DB::raw('COUNT(*) as pedidos'))
            ->with('comercio')
            ->groupBy('comercio_id')
            ->orderByDesc('total_ventas')
            ->get();

        return view('admin.reportes.index', compact(
            'totalVentas', 'totalPedidos', 'pedidosPorEstado',
            'productosMasVendidos', 'ventasPorComercio', 'desde', 'hasta'
        ));
    }

    public function exportarCSV(Request $request)
    {
        $desde = $request->get('desde', now()->startOfMonth()->format('Y-m-d'));
        $hasta = $request->get('hasta', now()->format('Y-m-d'));

        $pedidos = Pedido::with(['comprador', 'comercio'])
            ->whereBetween('created_at', [$desde, $hasta.' 23:59:59'])
            ->get();

        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename="reporte_ventas.csv"'];

        $callback = function() use ($pedidos) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Comprador', 'Comercio', 'Total', 'Estado', 'Fecha']);
            foreach ($pedidos as $p) {
                fputcsv($file, [
                    $p->id,
                    $p->comprador->name ?? '',
                    $p->comercio->nombre ?? '',
                    $p->total,
                    $p->estado,
                    $p->created_at->format('d/m/Y H:i'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
