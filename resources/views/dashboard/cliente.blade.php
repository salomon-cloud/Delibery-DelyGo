@extends('layouts.app')

@section('title', 'Dashboard Cliente - DelyFud')
@section('header', 'Bienvenido Cliente - Explora Restaurantes')

@section('content')

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
    <div>
        <h3>Categorías Disponibles</h3>
        @forelse($categorias as $categoria)
            <div style="border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 5px;">
                <h4>{{ $categoria->nombre }}</h4>
                @if($categoria->descripcion)
                    <p>{{ $categoria->descripcion }}</p>
                @endif
                <small>{{ $categoria->cantidad_productos }} productos disponibles</small>
            </div>
        @empty
            <p>No hay categorías disponibles en este momento.</p>
        @endforelse
    </div>
    
    <div>
        <h3>Mis Órdenes Recientes</h3>
        @forelse($mis_ordenes as $orden)
            <div style="border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 5px;">
                <h4>Orden #{{ $orden->id }}</h4>
                <p><strong>Restaurante:</strong> {{ $orden->restaurante->name }}</p>
                <p><strong>Estado:</strong> {{ ucfirst($orden->estado) }}</p>
                <p><strong>Total:</strong> ${{ number_format($orden->total, 2) }}</p>
                <small>{{ $orden->created_at->format('d/m/Y H:i') }}</small>
            </div>
        @empty
            <p>No tienes órdenes registradas.</p>
        @endforelse
    </div>
</div>

<div>
    <h3>Productos Destacados</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 15px;">
        @forelse($productos_destacados as $producto)
            <div style="border: 1px solid #ddd; padding: 15px; border-radius: 5px;">
                <h4>{{ $producto->nombre }}</h4>
                <p>{{ $producto->descripcion }}</p>
                <p><strong>Precio:</strong> ${{ number_format($producto->precio, 2) }}</p>
                <p><strong>Restaurante:</strong> {{ $producto->restaurante->name }}</p>
                <p><strong>Categoría:</strong> {{ $producto->categoria->nombre }}</p>
                @if($producto->estaDisponible())
                    <button style="background-color: #28a745; color: white; padding: 8px 15px; border: none; border-radius: 3px;">
                        Disponible (Stock: {{ $producto->stock }})
                    </button>
                @else
                    <button style="background-color: #dc3545; color: white; padding: 8px 15px; border: none; border-radius: 3px;" disabled>
                        No Disponible
                    </button>
                @endif
            </div>
        @empty
            <p>No hay productos disponibles en este momento.</p>
        @endforelse
    </div>
</div>

<div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 5px;">
    <h4>Funcionalidades del Cliente:</h4>
    <ul>
        <li>Ver productos por categoría</li>
        <li>Agregar productos al carrito</li>
        <li>Realizar pedidos</li>
        <li>Seguimiento de órdenes en tiempo real</li>
        <li>Historial de pedidos</li>
        <li>Calificar restaurantes y productos</li>
    </ul>
    <p><em>Esta es la versión básica sin diseño. Las funcionalidades se irán implementando progresivamente.</em></p>
</div>

@endsection