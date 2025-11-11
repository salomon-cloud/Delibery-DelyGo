<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'categoria_id',
        'restaurante_id', // usuario que es restaurante
        'imagen',
        'activo',
        'tiempo_preparacion', // en minutos
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'stock' => 'integer',
        'activo' => 'boolean',
        'tiempo_preparacion' => 'integer',
    ];

    /**
     * Relación: Categoría del producto
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    /**
     * Relación: Restaurante que ofrece el producto
     */
    public function restaurante()
    {
        return $this->belongsTo(User::class, 'restaurante_id');
    }

    /**
     * Scope: Solo productos activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope: Productos disponibles (con stock)
     */
    public function scopeDisponibles($query)
    {
        return $query->where('activo', true)->where('stock', '>', 0);
    }

    /**
     * Scope: Por categoría
     */
    public function scopePorCategoria($query, $categoriaId)
    {
        return $query->where('categoria_id', $categoriaId);
    }

    /**
     * Scope: Por restaurante
     */
    public function scopePorRestaurante($query, $restauranteId)
    {
        return $query->where('restaurante_id', $restauranteId);
    }

    /**
     * Verificar si el producto está disponible
     */
    public function estaDisponible()
    {
        return $this->activo && $this->stock > 0;
    }

    /**
     * Reducir stock del producto
     */
    public function reducirStock($cantidad)
    {
        if ($this->stock >= $cantidad) {
            $this->stock -= $cantidad;
            $this->save();
            return true;
        }
        return false;
    }
}