<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuarios de prueba
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@delyfud.com',
            'password' => Hash::make('password'),
            'tipo_usuario' => 'admin',
            'telefono' => '1234567890',
            'direccion' => 'Oficina Central',
            'activo' => true,
        ]);

        $restaurante = User::create([
            'name' => 'Restaurante La Delicia',
            'email' => 'restaurante@delyfud.com',
            'password' => Hash::make('password'),
            'tipo_usuario' => 'restaurante',
            'telefono' => '9876543210',
            'direccion' => 'Calle Principal 123',
            'activo' => true,
        ]);

        $repartidor = User::create([
            'name' => 'Juan Repartidor',
            'email' => 'repartidor@delyfud.com',
            'password' => Hash::make('password'),
            'tipo_usuario' => 'repartidor',
            'telefono' => '5555555555',
            'direccion' => 'Zona Norte',
            'activo' => true,
        ]);

        $cliente = User::create([
            'name' => 'María Cliente',
            'email' => 'cliente@delyfud.com',
            'password' => Hash::make('password'),
            'tipo_usuario' => 'cliente',
            'telefono' => '1111111111',
            'direccion' => 'Av. Libertad 456',
            'activo' => true,
        ]);

        // Crear categorías
        $categorias = [
            [
                'nombre' => 'Comida Rápida',
                'slug' => 'comida-rapida',
                'descripcion' => 'Hamburguesas, hot dogs, papas fritas',
                'icono' => '🍔',
                'color' => '#ff6b6b',
                'orden' => 1,
            ],
            [
                'nombre' => 'Pizza',
                'slug' => 'pizza',
                'descripcion' => 'Pizzas artesanales y tradicionales',
                'icono' => '🍕',
                'color' => '#4ecdc4',
                'orden' => 2,
            ],
            [
                'nombre' => 'Comida Mexicana',
                'slug' => 'comida-mexicana',
                'descripcion' => 'Tacos, quesadillas, burritos',
                'icono' => '🌮',
                'color' => '#45b7d1',
                'orden' => 3,
            ],
            [
                'nombre' => 'Bebidas',
                'slug' => 'bebidas',
                'descripcion' => 'Refrescos, jugos, aguas',
                'icono' => '🥤',
                'color' => '#f9ca24',
                'orden' => 4,
            ],
        ];

        foreach ($categorias as $categoriaData) {
            $categoria = Categoria::create($categoriaData);
            
            // Crear productos para cada categoría
            if ($categoria->nombre === 'Comida Rápida') {
                Producto::create([
                    'nombre' => 'Hamburguesa Clásica',
                    'descripcion' => 'Hamburguesa con carne, lechuga, tomate y queso',
                    'precio' => 89.50,
                    'stock' => 25,
                    'categoria_id' => $categoria->id,
                    'restaurante_id' => $restaurante->id,
                    'activo' => true,
                    'tiempo_preparacion' => 15,
                ]);

                Producto::create([
                    'nombre' => 'Papas Fritas',
                    'descripcion' => 'Papas fritas crujientes con sal',
                    'precio' => 35.00,
                    'stock' => 50,
                    'categoria_id' => $categoria->id,
                    'restaurante_id' => $restaurante->id,
                    'activo' => true,
                    'tiempo_preparacion' => 5,
                ]);
            }

            if ($categoria->nombre === 'Pizza') {
                Producto::create([
                    'nombre' => 'Pizza Margarita',
                    'descripcion' => 'Pizza con tomate, mozzarella y albahaca',
                    'precio' => 125.00,
                    'stock' => 15,
                    'categoria_id' => $categoria->id,
                    'restaurante_id' => $restaurante->id,
                    'activo' => true,
                    'tiempo_preparacion' => 25,
                ]);
            }

            if ($categoria->nombre === 'Bebidas') {
                Producto::create([
                    'nombre' => 'Coca Cola 600ml',
                    'descripcion' => 'Refresco de cola, botella de 600ml',
                    'precio' => 25.00,
                    'stock' => 100,
                    'categoria_id' => $categoria->id,
                    'restaurante_id' => $restaurante->id,
                    'activo' => true,
                    'tiempo_preparacion' => 1,
                ]);
            }
        }

        // Actualizar cantidad de productos en categorías
        Categoria::all()->each(function ($categoria) {
            $categoria->cantidad_productos = $categoria->productos()->count();
            $categoria->save();
        });
    }
}
