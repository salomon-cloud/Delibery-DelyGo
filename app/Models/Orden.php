<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;

    const ESTADO_RECIBIDA = 'recibida';
    const ESTADO_PREPARANDO = 'preparando';
    const ESTADO_EN_CAMINO = 'en_camino';
    const ESTADO_ENTREGADA = 'entregada';
    const ESTADO_CANCELADA = 'cancelada';

    protected $table = 'ordenes';

    protected $fillable = [
        'cliente_id',
        'restaurante_id',
        'repartidor_id',
        'estado',
        'total',
        'direccion_entrega',
        'telefono_contacto',
        'notas',
        'tiempo_estimado',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'tiempo_estimado' => 'integer',
    ];

    /**
     * Relación: Cliente que realizó la orden
     */
    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    /**
     * Relación: Restaurante que prepara la orden
     */
    public function restaurante()
    {
        return $this->belongsTo(User::class, 'restaurante_id');
    }

    /**
     * Relación: Repartidor asignado
     */
    public function repartidor()
    {
        return $this->belongsTo(User::class, 'repartidor_id');
    }

    /**
     * Relación: Detalles de la orden (productos)
     */
    public function detalles()
    {
        return $this->hasMany(OrdenDetalle::class, 'orden_id');
    }

    /**
     * Scope: Por estado
     */
    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    /**
     * Scope: Por cliente
     */
    public function scopePorCliente($query, $clienteId)
    {
        return $query->where('cliente_id', $clienteId);
    }

    /**
     * Scope: Por restaurante
     */
    public function scopePorRestaurante($query, $restauranteId)
    {
        return $query->where('restaurante_id', $restauranteId);
    }

    /**
     * Scope: Por repartidor
     */
    public function scopePorRepartidor($query, $repartidorId)
    {
        return $query->where('repartidor_id', $repartidorId);
    }

    /**
     * Cambiar estado de la orden (State Pattern básico)
     */
    public function cambiarEstado($nuevoEstado)
    {
        $estadosValidos = [
            self::ESTADO_RECIBIDA => [self::ESTADO_PREPARANDO, self::ESTADO_CANCELADA],
            self::ESTADO_PREPARANDO => [self::ESTADO_EN_CAMINO, self::ESTADO_CANCELADA],
            self::ESTADO_EN_CAMINO => [self::ESTADO_ENTREGADA],
        ];

        if (isset($estadosValidos[$this->estado]) && 
            in_array($nuevoEstado, $estadosValidos[$this->estado])) {
            $this->estado = $nuevoEstado;
            $this->save();
            return true;
        }

        return false;
    }

    /**
     * Verificar si la orden puede ser cancelada
     */
    public function puedeSerCancelada()
    {
        return in_array($this->estado, [self::ESTADO_RECIBIDA, self::ESTADO_PREPARANDO]);
    }

    /**
     * Calcular total de la orden
     */
    public function calcularTotal()
    {
        $total = $this->detalles->sum(function ($detalle) {
            return $detalle->cantidad * $detalle->precio_unitario;
        });

        $this->total = $total;
        $this->save();

        return $total;
    }
}