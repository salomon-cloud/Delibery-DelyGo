@extends('layouts.app')

@section('title', 'Dashboard Admin - DelyFud')
@section('header', 'Panel de Administración')

@section('content')

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div style="background: #17a2b8; color: white; padding: 20px; border-radius: 5px; text-align: center;">
        <h3>{{ $stats['total_usuarios'] }}</h3>
        <p>Total Usuarios</p>
    </div>
    <div style="background: #28a745; color: white; padding: 20px; border-radius: 5px; text-align: center;">
        <h3>{{ $stats['total_ordenes'] }}</h3>
        <p>Total Órdenes</p>
    </div>
    <div style="background: #ffc107; color: black; padding: 20px; border-radius: 5px; text-align: center;">
        <h3>{{ $stats['total_productos'] }}</h3>
        <p>Total Productos</p>
    </div>
    <div style="background: #dc3545; color: white; padding: 20px; border-radius: 5px; text-align: center;">
        <h3>{{ $stats['ordenes_pendientes'] }}</h3>
        <p>Órdenes Pendientes</p>
    </div>
</div>

<div>
    <h3>Órdenes Recientes</h3>
    @forelse($ordenes_recientes as $orden)
        <div style="border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 5px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 15px;">
                <div>
                    <strong>Orden #{{ $orden->id }}</strong><br>
                    <small>{{ $orden->created_at->format('d/m/Y H:i') }}</small>
                </div>
                <div>
                    <strong>Cliente:</strong> {{ $orden->cliente->name }}<br>
                    <strong>Restaurante:</strong> {{ $orden->restaurante->name }}
                </div>
                <div>
                    <strong>Estado:</strong> 
                    <span style="padding: 2px 8px; border-radius: 3px; font-size: 12px; color: white;
                        background-color: 
                        @if($orden->estado == 'recibida') #6c757d
                        @elseif($orden->estado == 'preparando') #ffc107
                        @elseif($orden->estado == 'en_camino') #17a2b8
                        @elseif($orden->estado == 'entregada') #28a745
                        @else #dc3545
                        @endif;">
                        {{ ucfirst($orden->estado) }}
                    </span>
                </div>
                <div>
                    <strong>Total:</strong> ${{ number_format($orden->total, 2) }}
                </div>
            </div>
        </div>
    @empty
        <p>No hay órdenes registradas.</p>
    @endforelse
</div>

<div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 5px;">
    <h4>Funcionalidades del Administrador:</h4>
    <ul>
        <li>Gestión completa de usuarios (CRUD)</li>
        <li>Gestión de categorías y productos</li>
        <li>Asignación manual de repartidores a órdenes</li>
        <li>Supervisión en tiempo real de todas las órdenes</li>
        <li>Reportes y estadísticas del sistema</li>
        <li>Configuración general del sistema</li>
    </ul>
</div>

@endsection