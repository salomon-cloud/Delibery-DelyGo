<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    const TIPO_CLIENTE = 'cliente';
    const TIPO_RESTAURANTE = 'restaurante';
    const TIPO_REPARTIDOR = 'repartidor';
    const TIPO_ADMIN = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tipo_usuario',
        'telefono',
        'direccion',
        'activo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'activo' => 'boolean',
        ];
    }

    /**
     * Scope: Solo usuarios activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope: Usuarios por tipo
     */
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo_usuario', $tipo);
    }

    /**
     * Verificar si es cliente
     */
    public function esCliente()
    {
        return $this->tipo_usuario === self::TIPO_CLIENTE;
    }

    /**
     * Verificar si es restaurante
     */
    public function esRestaurante()
    {
        return $this->tipo_usuario === self::TIPO_RESTAURANTE;
    }

    /**
     * Verificar si es repartidor
     */
    public function esRepartidor()
    {
        return $this->tipo_usuario === self::TIPO_REPARTIDOR;
    }

    /**
     * Verificar si es admin
     */
    public function esAdmin()
    {
        return $this->tipo_usuario === self::TIPO_ADMIN;
    }

    /**
     * Obtener el tipo de usuario formateado
     */
    public function getTipoUsuarioFormateadoAttribute()
    {
        return ucfirst($this->tipo_usuario);
    }
}
