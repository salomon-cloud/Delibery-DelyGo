@extends('layouts.app')

@section('title', 'Dashboard Repartidor - DelyFud')
@section('header', 'Panel del Repartidor')

@section('content')

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div style="background: #17a2b8; color: white; padding: 20px; border-radius: 5px; text-align: center;">
        <h3>{{ $stats['entregas_asignadas'] }}</h3>
        <p>Entregas Asignadas</p>
    </div>
    <div style="background: #28a745; color: white; padding: 20px; border-radius: 5px; text-align: center;">
        <h3>{{ $stats['entregas_completadas_hoy'] }}</h3>
        <p>Entregas Completadas Hoy</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
    <div>
        <h3>Mis Entregas Pendientes</h3>
        @forelse($entregas_pendientes as $entrega)
            <div style="border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 5px;">
                <h4>Orden #{{ $entrega->id }}</h4>
                <p><strong>Cliente:</strong> {{ $entrega->cliente->name }}</p>
                <p><strong>Teléfono:</strong> {{ $entrega->telefono_contacto }}</p>
                <p><strong>Restaurante:</strong> {{ $entrega->restaurante->name }}</p>
                <p><strong>Dirección de Entrega:</strong> {{ $entrega->direccion_entrega }}</p>
                <p><strong>Total:</strong> ${{ number_format($entrega->total, 2) }}</p>
                @if($entrega->notas)
                    <p><strong>Notas:</strong> {{ $entrega->notas }}</p>
                @endif
                
                <div style="margin-top: 10px;">
                    <button style="background-color: #28a745; color: white; padding: 8px 15px; border: none; border-radius: 3px;">
                        Marcar como Entregada
                    </button>
                </div>
                
                <small>Asignada: {{ $entrega->updated_at->format('d/m/Y H:i') }}</small>
            </div>
        @empty
            <p>No tienes entregas asignadas en este momento.</p>
        @endforelse
    </div>
    
    <div>
        <h3>Órdenes Disponibles para Asignar</h3>
        @forelse($ordenes_disponibles as $orden)
            <div style="border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 5px;">
                <h4>Orden #{{ $orden->id }}</h4>
                <p><strong>Cliente:</strong> {{ $orden->cliente->name }}</p>
                <p><strong>Restaurante:</strong> {{ $orden->restaurante->name }}</p>
                <p><strong>Dirección:</strong> {{ $orden->direccion_entrega }}</p>
                <p><strong>Total:</strong> ${{ number_format($orden->total, 2) }}</p>
                
                <div style="margin-top: 10px;">
                    <button style="background-color: #007bff; color: white; padding: 8px 15px; border: none; border-radius: 3px;">
                        Tomar Esta Entrega
                    </button>
                </div>
                
                <small>Lista desde: {{ $orden->updated_at->format('d/m/Y H:i') }}</small>
            </div>
        @empty
            <p>No hay órdenes disponibles para entrega en este momento.</p>
        @endforelse
    </div>
</div>

<div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 5px;">
    <h4>Funcionalidades del Repartidor:</h4>
    <ul>
        <li>Ver órdenes listas para entrega</li>
        <li>Autoasignarse a entregas disponibles</li>
        <li>Actualizar estado de entregas (en camino → entregada)</li>
        <li>Ver información de contacto de clientes</li>
        <li>Historial de entregas realizadas</li>
        <li>Tracking básico de ubicación (simplificado)</li>
    </ul>
</div>

@endsection