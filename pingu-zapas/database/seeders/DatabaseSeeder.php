<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Descuento;
use App\Models\Noticia;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\TallaStock;
use App\Models\User;
use App\Models\Zapatilla;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        PedidoItem::query()->delete();
        Pedido::query()->delete();
        TallaStock::query()->delete();
        Noticia::query()->delete();
        Descuento::query()->delete();
        Zapatilla::query()->delete();
        Categoria::query()->delete();
        User::query()->delete();

        $admin = User::create([
            'name' => 'Admin Pingu',
            'email' => 'admin@pinguzapas.com',
            'password' => Hash::make('password'),
            'telefono' => '600100200',
            'direccion' => 'Avenida de la Innovacion 18',
            'ciudad' => 'Madrid',
            'codigo_postal' => '28001',
            'pais' => 'España',
            'rol' => 'admin',
            'email_verified_at' => now(),
        ]);

        $clientes = collect([
            ['name' => 'Clara Montes', 'email' => 'clara@pinguzapas.local', 'ciudad' => 'Sevilla'],
            ['name' => 'Diego Varela', 'email' => 'diego@pinguzapas.local', 'ciudad' => 'Valencia'],
            ['name' => 'Nora Salas', 'email' => 'nora@pinguzapas.local', 'ciudad' => 'Bilbao'],
        ])->map(function (array $cliente) {
            return User::create([
                ...$cliente,
                'password' => Hash::make('password'),
                'telefono' => fake()->numerify('6########'),
                'direccion' => fake()->streetAddress(),
                'codigo_postal' => fake()->postcode(),
                'pais' => 'España',
                'rol' => 'cliente',
                'email_verified_at' => now(),
            ]);
        });

        $categorias = collect([
            ['nombre' => 'Urbana', 'descripcion' => 'Modelos para uso diario con perfil moderno.', 'imagen' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=80'],
            ['nombre' => 'Running', 'descripcion' => 'Siluetas ligeras para ritmo constante y comodidad.', 'imagen' => 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?auto=format&fit=crop&w=900&q=80'],
            ['nombre' => 'Court', 'descripcion' => 'Inspiradas en pista y movimiento lateral.', 'imagen' => 'https://images.unsplash.com/photo-1515955656352-a1fa3ffcd111?auto=format&fit=crop&w=900&q=80'],
            ['nombre' => 'Skate', 'descripcion' => 'Suela firme y estructura reforzada para tabla.', 'imagen' => 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?auto=format&fit=crop&w=900&q=80'],
            ['nombre' => 'Trail', 'descripcion' => 'Agarre extra y materiales resistentes para exterior.', 'imagen' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?auto=format&fit=crop&w=900&q=80'],
        ])->map(fn (array $categoria) => Categoria::create([
            ...$categoria,
            'slug' => Str::slug($categoria['nombre']),
        ]))->keyBy('nombre');

        $catalogo = [
            [
                'categoria' => 'Urbana',
                'nombre' => 'Astra Loop One',
                'marca' => 'Astra',
                'modelo' => 'Loop',
                'precio' => 129.90,
                'destacado' => true,
                'descripcion' => 'Perfil limpio, acolchado suave y combinacion neutra para rotacion diaria.',
                'imagen_principal' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=80',
                'imagenes_extra' => [
                    'https://images.unsplash.com/photo-1549298916-b41d501d3772?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1608231387042-66d1773070a5?auto=format&fit=crop&w=900&q=80',
                ],
                'tallas' => [38 => 4, 39 => 6, 40 => 7, 41 => 5, 42 => 3, 43 => 2],
            ],
            [
                'categoria' => 'Urbana',
                'nombre' => 'Nebula Frame Low',
                'marca' => 'Nebula',
                'modelo' => 'Frame',
                'precio' => 144.00,
                'destacado' => true,
                'descripcion' => 'Base retro y paneles tecnicos para un look de calle muy versatil.',
                'imagen_principal' => 'https://images.unsplash.com/photo-1600185365926-3a2ce3cdb9eb?auto=format&fit=crop&w=900&q=80',
                'imagenes_extra' => [
                    'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?auto=format&fit=crop&w=900&q=80',
                ],
                'tallas' => [39 => 5, 40 => 8, 41 => 6, 42 => 5, 43 => 1],
            ],
            [
                'categoria' => 'Running',
                'nombre' => 'Volt Sprint Echo',
                'marca' => 'Volt',
                'modelo' => 'Sprint Echo',
                'precio' => 158.50,
                'destacado' => true,
                'descripcion' => 'Mediasuela reactiva y upper transpirable para entrenos medios.',
                'imagen_principal' => 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?auto=format&fit=crop&w=900&q=80',
                'imagenes_extra' => [
                    'https://images.unsplash.com/photo-1552346154-21d32810aba3?auto=format&fit=crop&w=900&q=80',
                ],
                'tallas' => [40 => 5, 41 => 8, 42 => 8, 43 => 6, 44 => 4],
            ],
            [
                'categoria' => 'Running',
                'nombre' => 'Northstar Glide 3',
                'marca' => 'Northstar',
                'modelo' => 'Glide 3',
                'precio' => 171.90,
                'destacado' => false,
                'descripcion' => 'Pensada para rodajes largos con sensacion estable y amortiguada.',
                'imagen_principal' => 'https://images.unsplash.com/photo-1556906781-9a412961c28c?auto=format&fit=crop&w=900&q=80',
                'imagenes_extra' => [],
                'tallas' => [39 => 2, 40 => 5, 41 => 7, 42 => 5, 43 => 5, 44 => 3],
            ],
            [
                'categoria' => 'Court',
                'nombre' => 'Orbit Pivot Mid',
                'marca' => 'Orbit',
                'modelo' => 'Pivot Mid',
                'precio' => 163.75,
                'destacado' => true,
                'descripcion' => 'Cuello medio, soporte lateral y presencia fuerte sobre pista o asfalto.',
                'imagen_principal' => 'https://images.unsplash.com/photo-1515955656352-a1fa3ffcd111?auto=format&fit=crop&w=900&q=80',
                'imagenes_extra' => [],
                'tallas' => [40 => 3, 41 => 4, 42 => 6, 43 => 5, 44 => 2],
            ],
            [
                'categoria' => 'Court',
                'nombre' => 'Prisma Control Low',
                'marca' => 'Prisma',
                'modelo' => 'Control Low',
                'precio' => 149.99,
                'destacado' => false,
                'descripcion' => 'Baja al suelo, estable y comoda para cambios de ritmo cortos.',
                'imagen_principal' => 'https://images.unsplash.com/photo-1605348532760-6753d2c43329?auto=format&fit=crop&w=900&q=80',
                'imagenes_extra' => [],
                'tallas' => [39 => 4, 40 => 6, 41 => 6, 42 => 4, 43 => 2],
            ],
            [
                'categoria' => 'Skate',
                'nombre' => 'Drift Boardline',
                'marca' => 'Drift',
                'modelo' => 'Boardline',
                'precio' => 118.00,
                'destacado' => false,
                'descripcion' => 'Suela adherente y puntera reforzada para sesiones largas.',
                'imagen_principal' => 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?auto=format&fit=crop&w=900&q=80',
                'imagenes_extra' => [],
                'tallas' => [38 => 2, 39 => 3, 40 => 5, 41 => 6, 42 => 5, 43 => 3],
            ],
            [
                'categoria' => 'Skate',
                'nombre' => 'Luma Deck Pro',
                'marca' => 'Luma',
                'modelo' => 'Deck Pro',
                'precio' => 126.40,
                'destacado' => false,
                'descripcion' => 'Lengueta acolchada y mezcla de ante sintetico con mesh tecnico.',
                'imagen_principal' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?auto=format&fit=crop&w=900&q=80',
                'imagenes_extra' => [],
                'tallas' => [39 => 2, 40 => 4, 41 => 7, 42 => 4, 43 => 2],
            ],
            [
                'categoria' => 'Trail',
                'nombre' => 'Ridge Horizon X',
                'marca' => 'Ridge',
                'modelo' => 'Horizon X',
                'precio' => 182.20,
                'destacado' => true,
                'descripcion' => 'Taqueado profundo y upper protegido para rutas mixtas.',
                'imagen_principal' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?auto=format&fit=crop&w=900&q=80',
                'imagenes_extra' => [],
                'tallas' => [40 => 4, 41 => 6, 42 => 6, 43 => 6, 44 => 4, 45 => 2],
            ],
            [
                'categoria' => 'Trail',
                'nombre' => 'Kite Terrain Flow',
                'marca' => 'Kite',
                'modelo' => 'Terrain Flow',
                'precio' => 167.80,
                'destacado' => false,
                'descripcion' => 'Drop equilibrado y traccion constante para salidas rapidas.',
                'imagen_principal' => 'https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2?auto=format&fit=crop&w=900&q=80',
                'imagenes_extra' => [],
                'tallas' => [39 => 2, 40 => 5, 41 => 5, 42 => 6, 43 => 4, 44 => 2],
            ],
        ];

        $zapatillas = collect($catalogo)->map(function (array $item) use ($categorias) {
            $zapatilla = Zapatilla::create([
                'categoria_id' => $categorias[$item['categoria']]->id,
                'nombre' => $item['nombre'],
                'slug' => Str::slug($item['nombre']),
                'descripcion' => $item['descripcion'],
                'marca' => $item['marca'],
                'modelo' => $item['modelo'],
                'precio' => $item['precio'],
                'imagen_principal' => $item['imagen_principal'],
                'imagenes_extra' => $item['imagenes_extra'],
                'activo' => true,
                'destacado' => $item['destacado'],
            ]);

            foreach ($item['tallas'] as $talla => $stock) {
                TallaStock::create([
                    'zapatilla_id' => $zapatilla->id,
                    'talla' => $talla,
                    'stock' => $stock,
                ]);
            }

            return $zapatilla;
        });

        $descuentos = collect([
            [
                'codigo' => 'BIENVENIDA10',
                'descripcion' => '10% para primeras compras.',
                'tipo' => 'porcentaje',
                'valor' => 10,
                'minimo_pedido' => 80,
                'maximo_descuento' => 25,
                'usos_maximos' => 200,
                'usos_actuales' => 12,
                'activo' => true,
                'fecha_inicio' => now()->subDays(10),
                'fecha_fin' => now()->addMonths(2),
            ],
            [
                'codigo' => 'ENVIOFLEX',
                'descripcion' => 'Descuento fijo para pedidos de trail y running.',
                'tipo' => 'fijo',
                'valor' => 12,
                'minimo_pedido' => 120,
                'maximo_descuento' => null,
                'usos_maximos' => 100,
                'usos_actuales' => 7,
                'activo' => true,
                'fecha_inicio' => now()->subDays(3),
                'fecha_fin' => now()->addMonth(),
            ],
        ])->map(fn (array $data) => Descuento::create($data));

        $pedidosData = [
            [
                'user' => $clientes[0],
                'estado' => 'enviado',
                'items' => [
                    ['zapatilla' => $zapatillas[0], 'talla' => 40, 'cantidad' => 1],
                    ['zapatilla' => $zapatillas[4], 'talla' => 42, 'cantidad' => 1],
                ],
                'descuento' => $descuentos[0],
            ],
            [
                'user' => $clientes[1],
                'estado' => 'preparando',
                'items' => [
                    ['zapatilla' => $zapatillas[2], 'talla' => 42, 'cantidad' => 1],
                ],
                'descuento' => null,
            ],
            [
                'user' => $clientes[2],
                'estado' => 'entregado',
                'items' => [
                    ['zapatilla' => $zapatillas[8], 'talla' => 43, 'cantidad' => 1],
                    ['zapatilla' => $zapatillas[6], 'talla' => 41, 'cantidad' => 2],
                ],
                'descuento' => $descuentos[1],
            ],
        ];

        foreach ($pedidosData as $index => $pedidoData) {
            $subtotal = collect($pedidoData['items'])->sum(
                fn (array $item) => $item['zapatilla']->precio * $item['cantidad']
            );
            $descuento = $pedidoData['descuento'];
            $descuentoAplicado = 0;

            if ($descuento) {
                $descuentoAplicado = $descuento->tipo === 'porcentaje'
                    ? min($subtotal * ($descuento->valor / 100), $descuento->maximo_descuento ?? INF)
                    : $descuento->valor;
            }

            $gastosEnvio = $subtotal >= 150 ? 0 : 6.90;

            $pedido = Pedido::create([
                'user_id' => $pedidoData['user']->id,
                'descuento_id' => $descuento?->id,
                'numero_pedido' => 'PZ-' . now()->format('ymd') . '-' . str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT),
                'estado' => $pedidoData['estado'],
                'subtotal' => $subtotal,
                'descuento_aplicado' => round($descuentoAplicado, 2),
                'gastos_envio' => $gastosEnvio,
                'total' => round($subtotal - $descuentoAplicado + $gastosEnvio, 2),
                'nombre_envio' => $pedidoData['user']->name,
                'direccion_envio' => $pedidoData['user']->direccion,
                'ciudad_envio' => $pedidoData['user']->ciudad,
                'codigo_postal_envio' => $pedidoData['user']->codigo_postal,
                'pais_envio' => $pedidoData['user']->pais,
                'telefono_contacto' => $pedidoData['user']->telefono,
                'metodo_pago' => ['tarjeta', 'paypal', 'transferencia'][$index],
                'referencia_pago' => 'PAY-' . Str::upper(Str::random(8)),
                'notas' => $index === 1 ? 'Entregar por la tarde si es posible.' : null,
                'fecha_envio' => in_array($pedidoData['estado'], ['enviado', 'entregado'], true) ? now()->subDays(2 - $index) : null,
                'fecha_entrega' => $pedidoData['estado'] === 'entregado' ? now()->subDay() : null,
            ]);

            foreach ($pedidoData['items'] as $item) {
                PedidoItem::create([
                    'pedido_id' => $pedido->id,
                    'zapatilla_id' => $item['zapatilla']->id,
                    'talla' => $item['talla'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['zapatilla']->precio,
                    'subtotal' => $item['zapatilla']->precio * $item['cantidad'],
                ]);
            }
        }

        collect([
            [
                'titulo' => 'Nueva rotacion urbana para primavera',
                'resumen' => 'Cinco pares de perfil bajo para uso diario y looks versatiles.',
                'contenido' => 'La nueva seleccion mezcla acabados limpios, colores suaves y una construccion comoda para el dia a dia. El foco está en siluetas faciles de combinar y con stock amplio en tallas medias.',
                'categoria' => 'lanzamiento',
                'publicado' => true,
                'destacado' => true,
                'imagen_portada' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'titulo' => 'Como elegir talla si cambias de categoria',
                'resumen' => 'No siempre una running y una skate calzan igual.',
                'contenido' => 'Cada horma responde distinto. En running suele primar el espacio delantero, mientras que en skate conviene un ajuste mas firme. Por eso ahora el catalogo deja filtrar por talla con stock real.',
                'categoria' => 'general',
                'publicado' => true,
                'destacado' => false,
                'imagen_portada' => 'https://images.unsplash.com/photo-1600185365926-3a2ce3cdb9eb?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'titulo' => 'Semana flexible con codigos de bienvenida',
                'resumen' => 'Activamos nuevos descuentos para pedidos de entrada.',
                'contenido' => 'La tienda arranca con codigos simples y condiciones transparentes. Encontraras promos de porcentaje y tambien descuentos fijos para cestas concretas.',
                'categoria' => 'oferta',
                'publicado' => true,
                'destacado' => false,
                'imagen_portada' => 'https://images.unsplash.com/photo-1552346154-21d32810aba3?auto=format&fit=crop&w=900&q=80',
            ],
        ])->each(function (array $noticia, int $index) use ($admin) {
            Noticia::create([
                ...$noticia,
                'user_id' => $admin->id,
                'slug' => Str::slug($noticia['titulo']),
                'publicado_en' => now()->subDays($index + 1),
            ]);
        });
    }
}
