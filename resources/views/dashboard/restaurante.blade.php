@extends('layouts.app')

@section('title', 'Dashboard Restaurante - DelyFud')
@section('header', 'Panel del Restaurante')

@section('content')

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div style="background: #17a2b8; color: white; padding: 20px; border-radius: 5px; text-align: center;">
        <h3>{{ $stats['mis_productos'] }}</h3>
        <p>Mis Productos</p>
    </div>
    <div style="background: #ffc107; color: black; padding: 20px; border-radius: 5px; text-align: center;">
        <h3>{{ $stats['ordenes_pendientes'] }}</h3>
        <p>Órdenes Pendientes</p>
    </div>
    <div style="background: #28a745; color: white; padding: 20px; border-radius: 5px; text-align: center;">
        <h3>{{ $stats['ordenes_hoy'] }}</h3>
        <p>Órdenes Hoy</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
    <div>
        <h3>Órdenes Pendientes</h3>
        @forelse($ordenes_pendientes as $orden)
            <div style="border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 5px;">
                <h4>Orden #{{ $orden->id }}</h4>
                <p><strong>Cliente:</strong> {{ $orden->cliente->name }}</p>
                <p><strong>Estado:</strong> 
                    <span style="padding: 2px 8px; border-radius: 3px; font-size: 12px; color: white;
                        background-color: 
                        @if($orden->estado == 'recibida') #6c757d
                        @elseif($orden->estado == 'preparando') #ffc107
                        @else #17a2b8
                        @endif;">
                        {{ ucfirst($orden->estado) }}
                    </span>
                </p>
                <p><strong>Total:</strong> ${{ number_format($orden->total, 2) }}</p>
                <p><strong>Dirección:</strong> {{ $orden->direccion_entrega }}</p>
                
                <h5>Productos:</h5>
                @foreach($orden->detalles as $detalle)
                    <div style="background: #f8f9fa; padding: 10px; margin: 5px 0; border-radius: 3px;">
                        {{ $detalle->cantidad }}x {{ $detalle->producto->nombre }} 
                        <span style="float: right;">${{ number_format($detalle->subtotal, 2) }}</span>
                    </div>
                @endforeach
                
                <div style="margin-top: 10px;">
                    @if($orden->estado == 'recibida')
                        <button style="background-color: #ffc107; color: black; padding: 5px 10px; border: none; border-radius: 3px; margin-right: 5px;">
                            Marcar como Preparando
                        </button>
                    @elseif($orden->estado == 'preparando')
                        <button style="background-color: #17a2b8; color: white; padding: 5px 10px; border: none; border-radius: 3px; margin-right: 5px;">
                            Listo para Entrega
                        </button>
                    @endif
                    <button style="background-color: #dc3545; color: white; padding: 5px 10px; border: none; border-radius: 3px;">
                        Cancelar Orden
                    </button>
                </div>
                
                <small>Orden realizada: {{ $orden->created_at->format('d/m/Y H:i') }}</small>
            </div>
        @empty
            <p>No tienes órdenes pendientes en este momento.</p>
        @endforelse
    </div>
    
    <div>
        <h3>Mis Productos</h3>
        @forelse($productos as $producto)
            <div style="border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 5px;">
                <h4>{{ $producto->nombre }}</h4>
                <p>{{ $producto->descripcion }}</p>
                <p><strong>Precio:</strong> ${{ number_format($producto->precio, 2) }}</p>
                <p><strong>Stock:</strong> {{ $producto->stock }}</p>
                <p><strong>Categoría:</strong> {{ $producto->categoria->nombre }}</p>
                <p><strong>Estado:</strong> 
                    @if($producto->activo)
                        <span style="color: #28a745;">Activo</span>
                    @else
                        <span style="color: #dc3545;">Inactivo</span>
                    @endif
                </p>
                <div style="margin-top: 10px;">
                    <button style="background-color: #007bff; color: white; padding: 5px 10px; border: none; border-radius: 3px; margin-right: 5px;">
                        Editar
                    </button>
                    @if($producto->activo)
                        <button style="background-color: #6c757d; color: white; padding: 5px 10px; border: none; border-radius: 3px;">
                            Desactivar
                        </button>
                    @else
                        <button style="background-color: #28a745; color: white; padding: 5px 10px; border: none; border-radius: 3px;">
                            Activar
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <p>No tienes productos registrados. <a href="#">Agregar primer producto</a></p>
        @endforelse
        
        @if($productos->hasPages())
            <div style="margin-top: 20px;">
                {{ $productos->links() }}
            </div>
        @endif
    </div>
</div>

<div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 5px;">
    <h4>Funcionalidades del Restaurante:</h4>
    <ul>
        <li>Gestión de productos (CRUD)</li>
        <li>Recepción y procesamiento de órdenes</li>
        <li>Control de inventario/stock</li>
        <li>Cambio de estados de órdenes (recibida → preparando → listo)</li>
        <li>Tiempos de preparación estimados</li>
        <li>Estadísticas de ventas</li>
    </ul>
    <p><em>Esta es la versión básica sin diseño. Las funcionalidades se irán implementando progresivamente.</em></p>
</div>

@endsection