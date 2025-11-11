<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Orden;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Dashboard principal - redirige según tipo de usuario
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->esAdmin()) {
            return $this->adminDashboard();
        } elseif ($user->esRestaurante()) {
            return $this->restauranteDashboard();
        } elseif ($user->esRepartidor()) {
            return $this->repartidorDashboard();
        } else {
            return $this->clienteDashboard();
        }
    }

    /**
     * Dashboard del administrador
     */
    public function adminDashboard()
    {
        $stats = [
            'total_usuarios' => User::count(),
            'total_ordenes' => Orden::count(),
            'total_productos' => Producto::count(),
            'ordenes_pendientes' => Orden::porEstado(Orden::ESTADO_RECIBIDA)->count(),
        ];

        $ordenes_recientes = Orden::with(['cliente', 'restaurante'])
                                  ->orderBy('created_at', 'desc')
                                  ->take(10)
                                  ->get();

        return view('dashboard.admin', compact('stats', 'ordenes_recientes'));
    }

    /**
     * Dashboard del restaurante
     */
    public function restauranteDashboard()
    {
        $restaurante = Auth::user();
        
        $stats = [
            'mis_productos' => Producto::porRestaurante($restaurante->id)->count(),
            'ordenes_pendientes' => Orden::porRestaurante($restaurante->id)
                                         ->whereIn('estado', [Orden::ESTADO_RECIBIDA, Orden::ESTADO_PREPARANDO])
                                         ->count(),
            'ordenes_hoy' => Orden::porRestaurante($restaurante->id)
                                  ->whereDate('created_at', today())
                                  ->count(),
        ];

        $ordenes_pendientes = Orden::with(['cliente', 'detalles.producto'])
                                   ->porRestaurante($restaurante->id)
                                   ->whereIn('estado', [Orden::ESTADO_RECIBIDA, Orden::ESTADO_PREPARANDO])
                                   ->orderBy('created_at', 'asc')
                                   ->get();

        $productos = Producto::porRestaurante($restaurante->id)
                             ->with('categoria')
                             ->paginate(10);

        return view('dashboard.restaurante', compact('stats', 'ordenes_pendientes', 'productos'));
    }

    /**
     * Dashboard del repartidor
     */
    public function repartidorDashboard()
    {
        $repartidor = Auth::user();
        
        $stats = [
            'entregas_asignadas' => Orden::porRepartidor($repartidor->id)
                                         ->where('estado', Orden::ESTADO_EN_CAMINO)
                                         ->count(),
            'entregas_completadas_hoy' => Orden::porRepartidor($repartidor->id)
                                               ->where('estado', Orden::ESTADO_ENTREGADA)
                                               ->whereDate('updated_at', today())
                                               ->count(),
        ];

        $entregas_pendientes = Orden::with(['cliente', 'restaurante'])
                                    ->porRepartidor($repartidor->id)
                                    ->where('estado', Orden::ESTADO_EN_CAMINO)
                                    ->orderBy('created_at', 'asc')
                                    ->get();

        $ordenes_disponibles = Orden::with(['cliente', 'restaurante'])
                                    ->whereNull('repartidor_id')
                                    ->where('estado', Orden::ESTADO_PREPARANDO)
                                    ->orderBy('created_at', 'asc')
                                    ->get();

        return view('dashboard.repartidor', compact('stats', 'entregas_pendientes', 'ordenes_disponibles'));
    }

    /**
     * Dashboard del cliente
     */
    public function clienteDashboard()
    {
        $cliente = Auth::user();
        
        $categorias = Categoria::activas()
                               ->principales()
                               ->ordenadas()
                               ->get();

        $productos_destacados = Producto::activos()
                                        ->with(['categoria', 'restaurante'])
                                        ->take(12)
                                        ->get();

        $mis_ordenes = Orden::with(['restaurante', 'detalles'])
                            ->porCliente($cliente->id)
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();

        return view('dashboard.cliente', compact('categorias', 'productos_destacados', 'mis_ordenes'));
    }
}
