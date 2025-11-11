<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Categoria extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'icono',
        'color',
        'orden',
        'categoria_padre_id',
        'activo',
        'cantidad_productos',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'activo' => 'boolean',
        'orden' => 'integer',
        'cantidad_productos' => 'integer',
        'categoria_padre_id' => 'integer',
    ];

    /**
     * Boot del modelo para generar slug automáticamente
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($categoria) {
            if (empty($categoria->slug)) {
                $categoria->slug = Str::slug($categoria->nombre);
            }
        });

        static::updating(function ($categoria) {
            if ($categoria->isDirty('nombre') && empty($categoria->slug)) {
                $categoria->slug = Str::slug($categoria->nombre);
            }
        });
    }

    /**
     * Relación: Categoría padre (para subcategorías)
     */
    public function categoriaPadre()
    {
        return $this->belongsTo(Categoria::class, 'categoria_padre_id');
    }

    /**
     * Relación: Subcategorías
     */
    public function subcategorias()
    {
        return $this->hasMany(Categoria::class, 'categoria_padre_id');
    }

    /**
     * Relación: Productos de esta categoría
     */
    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria_id');
    }

    /**
     * Scope: Solo categorías activas
     */
    public function scopeActivas($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope: Solo categorías principales (sin padre)
     */
    public function scopePrincipales($query)
    {
        return $query->whereNull('categoria_padre_id');
    }

    /**
     * Scope: Ordenadas por campo orden
     */
    public function scopeOrdenadas($query)
    {
        return $query->orderBy('orden', 'asc')->orderBy('nombre', 'asc');
    }

    /**
     * Accessor: Obtener nombre completo con jerarquía
     */
    public function getNombreCompletoAttribute()
    {
        if ($this->categoriaPadre) {
            return $this->categoriaPadre->nombre . ' > ' . $this->nombre;
        }
        return $this->nombre;
    }
}