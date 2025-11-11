<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Mostrar formulario de login
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.login');
    }

    /**
     * Procesar login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirigir según el tipo de usuario
            $user = Auth::user();
            if ($user->esAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->esRestaurante()) {
                return redirect()->route('restaurante.dashboard');
            } elseif ($user->esRepartidor()) {
                return redirect()->route('repartidor.dashboard');
            } else {
                return redirect()->route('cliente.dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->withInput();
    }

    /**
     * Mostrar formulario de registro
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.register');
    }

    /**
     * Procesar registro
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'tipo_usuario' => 'required|in:cliente,restaurante,repartidor',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tipo_usuario' => $request->tipo_usuario,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'activo' => true,
        ]);

        Auth::login($user);

        // Redirigir según el tipo de usuario
        if ($user->esAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->esRestaurante()) {
            return redirect()->route('restaurante.dashboard');
        } elseif ($user->esRepartidor()) {
            return redirect()->route('repartidor.dashboard');
        } else {
            return redirect()->route('cliente.dashboard');
        }
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
