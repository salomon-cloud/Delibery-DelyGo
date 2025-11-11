@extends('layouts.app')

@section('title', 'Login - DelyFud')
@section('header', 'Iniciar Sesión')

@section('content')
<div style="max-width: 400px; margin: 0 auto;">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group text-center">
            <button type="submit">Iniciar Sesión</button>
        </div>
    </form>

    <div class="text-center" style="margin-top: 20px;">
        <p>¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
    </div>

    <div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 5px;">
        <h4>Usuarios registrados:</h4>
        <p><strong>Admin:</strong> admin@delyfud.com / password</p>
        <p><strong>Restaurante:</strong> restaurante@delyfud.com / password</p>
        <p><strong>Repartidor:</strong> repartidor@delyfud.com / password</p>
        <p><strong>Cliente:</strong> cliente@delyfud.com / password</p>
    </div>
</div>
@endsection