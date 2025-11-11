@extends('layouts.app')

@section('title', 'Registro - DelyFud')
@section('header', 'Registrarse')

@section('content')
<div style="max-width: 500px; margin: 0 auto;">
    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label for="tipo_usuario">Tipo de Usuario:</label>
            <select id="tipo_usuario" name="tipo_usuario" required>
                <option value="">Seleccionar...</option>
                <option value="cliente" {{ old('tipo_usuario') == 'cliente' ? 'selected' : '' }}>Cliente</option>
                <option value="restaurante" {{ old('tipo_usuario') == 'restaurante' ? 'selected' : '' }}>Restaurante</option>
                <option value="repartidor" {{ old('tipo_usuario') == 'repartidor' ? 'selected' : '' }}>Repartidor</option>
            </select>
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono (opcional):</label>
            <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}">
        </div>

        <div class="form-group">
            <label for="direccion">Dirección (opcional):</label>
            <textarea id="direccion" name="direccion" rows="3">{{ old('direccion') }}</textarea>
        </div>

        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmar Contraseña:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <div class="form-group text-center">
            <button type="submit">Registrarse</button>
        </div>
    </form>

    <div class="text-center" style="margin-top: 20px;">
        <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a></p>
    </div>
</div>
@endsection