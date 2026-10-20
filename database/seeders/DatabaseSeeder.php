<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles
        $adminRole = Role::create(['name' => 'admin']);
        $clienteRole = Role::create(['name' => 'cliente']);

        // 2. Usuarios de prueba
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678'),
            'role_id' => $adminRole->id,
        ]);

        $cliente = User::create([
            'name' => 'Cliente de Prueba',
            'email' => 'cliente@cliente.com',
            'password' => bcrypt('12345678'),
            'role_id' => $clienteRole->id,
        ]);

        // Algunos clientes extra generados por factory
        $otrosClientes = User::factory(5)->create(['role_id' => $clienteRole->id]);

        // 3. Dirección para el cliente principal
        Address::create([
            'user_id' => $cliente->id,
            'street' => 'Av. Siempre Viva 742',
            'city' => 'Rosario',
            'province' => 'Santa Fe',
            'postal_code' => 'S2000',
            'country' => 'Argentina',
            'is_default' => true,
        ]);

        // 4. Categorías
        $categorias = Category::factory(4)->create();

        // 5. Productos, cada uno con 1-2 categorías asociadas
        $productos = Product::factory(12)->create();

        foreach ($productos as $producto) {
            $producto->categories()->attach(
                $categorias->random(rand(1, 2))->pluck('id')->toArray()
            );
        }

        // 6. Pedidos de prueba con items, para distintos estados
        $todosLosClientes = $otrosClientes->push($cliente);

        foreach ($todosLosClientes as $userCliente) {
            $cantidadPedidos = rand(1, 3);

            for ($i = 0; $i < $cantidadPedidos; $i++) {
                $order = Order::factory()->create([
                    'user_id' => $userCliente->id,
                    'address_id' => $userCliente->addresses()->first()?->id,
                ]);

                $productosDelPedido = $productos->random(rand(1, 4));

                foreach ($productosDelPedido as $producto) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $producto->id,
                        'quantity' => rand(1, 3),
                        'unit_price' => $producto->price,
                    ]);
                }

                $order->recalculateTotal();
            }
        }

        // 7. Algunas reseñas de prueba
        foreach ($todosLosClientes->take(4) as $userCliente) {
            Review::create([
                'user_id' => $userCliente->id,
                'product_id' => $productos->random()->id,
                'rating' => rand(3, 5),
                'comment' => fake()->sentence(),
            ]);
        }
    }
}