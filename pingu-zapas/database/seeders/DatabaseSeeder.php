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
use Illuminate\Support\Facades\DB;


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

        // 1. USUARIOS
        DB::table('users')->insert([
            ['id' => 1, 'name' => 'Admin Pingu', 'email' => 'admin@pinguzapas.com', 'email_verified_at' => '2026-05-14 13:13:28', 'password' => '$2y$12$sDVt3ilpa.wRsyUvXSufQuIeLeXoVCK4fabaxpk3mqXQRHiRSquqG', 'telefono' => '600100200', 'direccion' => 'Avenida de la Innovacion 18', 'ciudad' => 'Madrid', 'codigo_postal' => '28001', 'pais' => 'España', 'rol' => 'admin', 'created_at' => '2026-05-14 13:13:28', 'updated_at' => '2026-05-14 13:13:28'],
            ['id' => 2, 'name' => 'Clara Montes', 'email' => 'clara@pinguzapas.local', 'email_verified_at' => '2026-05-14 13:13:28', 'password' => '$2y$12$lLSL2p7kcG0SOaN1eZMkCeAY0oZo99RmaX.2EbHBE1XoaCXQr.Bnm', 'telefono' => '605232364', 'direccion' => 'Rúa Antonio, 436, 62º 6º', 'ciudad' => 'Sevilla', 'codigo_postal' => '08586', 'pais' => 'España', 'rol' => 'cliente', 'created_at' => '2026-05-14 13:13:28', 'updated_at' => '2026-05-14 13:13:28'],
            ['id' => 3, 'name' => 'Diego Varela', 'email' => 'diego@pinguzapas.local', 'email_verified_at' => '2026-05-14 13:13:28', 'password' => '$2y$12$JvXqAFmPs.lvrbQ/x8o4MevjaqJjkmjAqRaMvx7Q6cOElic0Mn/8u', 'telefono' => '676040423', 'direccion' => 'Paseo Gracia, 35, 4º C', 'ciudad' => 'Valencia', 'codigo_postal' => '38770', 'pais' => 'España', 'rol' => 'cliente', 'created_at' => '2026-05-14 13:13:28', 'updated_at' => '2026-05-14 13:13:28'],
            ['id' => 4, 'name' => 'Nora Salas', 'email' => 'nora@pinguzapas.local', 'email_verified_at' => '2026-05-14 13:13:28', 'password' => '$2y$12$MLyrI4x.XJwyU255b3TbU.mpa8HY91TxBBjuBV5WQx799kvc7tD12', 'telefono' => '620719786', 'direccion' => 'Avinguda Eduardo, 3, 6º E', 'ciudad' => 'Bilbao', 'codigo_postal' => '15211', 'pais' => 'España', 'rol' => 'cliente', 'created_at' => '2026-05-14 13:13:28', 'updated_at' => '2026-05-14 13:13:28'],
        ]);

        // 2. CATEGORÍAS
        DB::table('categorias')->insert([
            ['id' => 1, 'nombre' => 'Casual', 'slug' => 'casual', 'descripcion' => 'Modelos para uso diario con perfil moderno.', 'imagen' => 'casual.png', 'created_at' => '2026-05-14 13:13:28', 'updated_at' => '2026-05-14 13:13:28'],
            ['id' => 2, 'nombre' => 'Running', 'slug' => 'running', 'descripcion' => 'Siluetas ligeras para ritmo constante y comodidad.', 'imagen' => 'running.png', 'created_at' => '2026-05-14 13:13:28', 'updated_at' => '2026-05-14 13:13:28'],
            ['id' => 3, 'nombre' => 'Basket', 'slug' => 'basket', 'descripcion' => 'Inspiradas en pista y movimiento lateral.', 'imagen' => 'basket.png', 'created_at' => '2026-05-14 13:13:28', 'updated_at' => '2026-05-14 13:13:28'],
            ['id' => 4, 'nombre' => 'Skate', 'slug' => 'skate', 'descripcion' => 'Suela firme y estructura reforzada para tabla.', 'imagen' => 'skate.png', 'created_at' => '2026-05-14 13:13:28', 'updated_at' => '2026-05-14 13:13:28'],
            ['id' => 5, 'nombre' => 'Chanclas', 'slug' => 'chanclas', 'descripcion' => 'Ideales para la piscina o playa.', 'imagen' => 'chanclas.png', 'created_at' => '2026-05-14 13:13:28', 'updated_at' => '2026-05-14 13:13:28'],
        ]);

        // 3. DESCUENTOS
        DB::table('descuentos')->insert([
            ['id' => 1, 'codigo' => 'BIENVENIDA10', 'descripcion' => '10% para primeras compras.', 'tipo' => 'porcentaje', 'valor' => 10.00, 'minimo_pedido' => 80.00, 'maximo_descuento' => 25.00, 'usos_maximos' => 200, 'usos_actuales' => 12, 'activo' => 1, 'fecha_inicio' => '2026-05-04 13:13:28', 'fecha_fin' => '2026-07-14 13:13:28', 'created_at' => '2026-05-14 13:13:28', 'updated_at' => '2026-05-14 13:13:28'],
            ['id' => 2, 'codigo' => 'ENVIOFLEX', 'descripcion' => 'Descuento fijo para pedidos.', 'tipo' => 'fijo', 'valor' => 12.00, 'minimo_pedido' => 120.00, 'maximo_descuento' => null, 'usos_maximos' => 100, 'usos_actuales' => 7, 'activo' => 1, 'fecha_inicio' => '2026-05-11 13:13:28', 'fecha_fin' => '2026-06-14 13:13:28', 'created_at' => '2026-05-14 13:13:28', 'updated_at' => '2026-05-14 13:13:28'],
            ['id' => 3, 'codigo' => 'PINGU', 'descripcion' => 'DESCUENTAZO DEL VERANO', 'tipo' => 'porcentaje', 'valor' => 75.00, 'minimo_pedido' => null, 'maximo_descuento' => null, 'usos_maximos' => 10, 'usos_actuales' => 0, 'activo' => 1, 'fecha_inicio' => '2026-05-31 22:00:00', 'fecha_fin' => '2026-08-31 21:59:00', 'created_at' => '2026-05-14 14:06:46', 'updated_at' => '2026-05-14 14:06:46'],
        ]);

        // 4. ZAPATILLAS (Corregido error en ID 12 y marcas)
        DB::table('zapatillas')->insert([
            ['id' => 1, 'categoria_id' => 1, 'nombre' => 'Mountain Everest Drill', 'slug' => 'mountain-everest-drill-a0r7rt', 'descripcion' => 'Amor por la playa.', 'marca' => 'Mountain', 'modelo' => 'Everest', 'precio' => 120.00, 'imagen_principal' => 'zapatillas/IiotWEZPyIA21Fukd6GB1B0i2KFXjJ5OXOlhw3dz.jpg', 'imagenes_extra' => '[]', 'activo' => 1, 'destacado' => 0, 'created_at' => '2026-05-14 13:28:15', 'updated_at' => '2026-05-14 13:28:15'],
            ['id' => 2, 'categoria_id' => 1, 'nombre' => 'Payatillas', 'slug' => 'payatillas-3bs9kh', 'descripcion' => 'Perfectas para ir de boda.', 'marca' => 'Payos', 'modelo' => 'Charca', 'precio' => 250.00, 'imagen_principal' => 'zapatillas/LNUpLMWwymhW9SIRjIwFku18KkMswzlGr6t28weh.jpg', 'imagenes_extra' => '[]', 'activo' => 1, 'destacado' => 1, 'created_at' => '2026-05-14 13:33:18', 'updated_at' => '2026-05-14 13:33:18'],
            ['id' => 3, 'categoria_id' => 1, 'nombre' => 'Adios Campos', 'slug' => 'adios-campos-13ytos', 'descripcion' => 'Para llevar con pantalones baggy.', 'marca' => 'Adios', 'modelo' => 'Campos', 'precio' => 120.00, 'imagen_principal' => 'zapatillas/YuqNkW3sdZMi75fZJkTHnNQym9gTtByJ4TduAogP.jpg', 'imagenes_extra' => '[]', 'activo' => 1, 'destacado' => 0, 'created_at' => '2026-05-14 13:35:36', 'updated_at' => '2026-05-14 13:35:36'],
            ['id' => 4, 'categoria_id' => 5, 'nombre' => 'Lango-Chanclas', 'slug' => 'lango-chanclas-gvcv0p', 'descripcion' => 'Duras como una langosta.', 'marca' => 'Chancletiñas', 'modelo' => 'Langosta', 'precio' => 14.99, 'imagen_principal' => 'zapatillas/RUAIcQJULCjLjQOjxkXlRBoZJc9QpPqNr5T2dEBC.jpg', 'imagenes_extra' => '[]', 'activo' => 1, 'destacado' => 0, 'created_at' => '2026-05-14 13:36:50', 'updated_at' => '2026-05-14 13:36:50'],
            ['id' => 5, 'categoria_id' => 5, 'nombre' => 'Octoflops', 'slug' => 'octoflops-gy24ln', 'descripcion' => 'Para amantes de los tentáculos.', 'marca' => 'Chancletiñas', 'modelo' => 'Pulpo', 'precio' => 26.99, 'imagen_principal' => 'zapatillas/lpheHZQEqllSpochJmLN2Gjc5jRZiuAi7p3pid4u.jpg', 'imagenes_extra' => '[]', 'activo' => 1, 'destacado' => 0, 'created_at' => '2026-05-14 13:38:12', 'updated_at' => '2026-05-14 13:38:12'],
            ['id' => 6, 'categoria_id' => 5, 'nombre' => 'Chanclas Rape', 'slug' => 'chanclas-rape-oyff3l', 'descripcion' => 'Pinrreles iluminados.', 'marca' => 'Chancletiñas', 'modelo' => 'Rape', 'precio' => 289.97, 'imagen_principal' => 'zapatillas/w43EvuZ3BAU7rOoitySBWoXGsAtrklFOVKTY4Kbo.jpg', 'imagenes_extra' => '[]', 'activo' => 1, 'destacado' => 1, 'created_at' => '2026-05-14 13:40:19', 'updated_at' => '2026-05-14 13:40:19'],
            ['id' => 7, 'categoria_id' => 3, 'nombre' => 'Ornito-Brinco', 'slug' => 'ornito-brinco-fa80vx', 'descripcion' => 'Para llegar a lo alto del aro.', 'marca' => 'Lebron', 'modelo' => 'James', 'precio' => 150.00, 'imagen_principal' => 'zapatillas/stR6GVcTQu6vk4TrknjPJdVVv6VO6TD5rvqAZpER.jpg', 'imagenes_extra' => '[]', 'activo' => 1, 'destacado' => 1, 'created_at' => '2026-05-14 13:42:47', 'updated_at' => '2026-05-14 13:42:47'],
            ['id' => 8, 'categoria_id' => 3, 'nombre' => 'Pingu-Steep', 'slug' => 'pingu-steep-io3roa', 'descripcion' => 'Deslízate como un pingüino.', 'marca' => 'Stephen', 'modelo' => 'Curry', 'precio' => 149.99, 'imagen_principal' => 'zapatillas/InDNBkIGuhof96RjXfnfa989fwXBEscZqFQ1afBB.jpg', 'imagenes_extra' => '[]', 'activo' => 1, 'destacado' => 0, 'created_at' => '2026-05-14 13:45:22', 'updated_at' => '2026-05-14 13:45:22'],
            ['id' => 9, 'categoria_id' => 3, 'nombre' => 'Bunny Loop Up', 'slug' => 'bunny-loop-up-x4v2fq', 'descripcion' => 'Mucho flow.', 'marca' => 'Benito', 'modelo' => 'Antonio', 'precio' => 148.99, 'imagen_principal' => 'zapatillas/nV1Ocx89SxELsraDPlWrfZKtHwuyGgsD2LuBg5lb.jpg', 'imagenes_extra' => '[]', 'activo' => 1, 'destacado' => 0, 'created_at' => '2026-05-14 13:47:14', 'updated_at' => '2026-05-14 13:47:14'],
            ['id' => 10, 'categoria_id' => 4, 'nombre' => 'Black Hole', 'slug' => 'black-hole-5mrcaz', 'descripcion' => 'Suela de rápido desplazamiento.', 'marca' => 'Tony Hawks', 'modelo' => 'Pro', 'precio' => 114.99, 'imagen_principal' => 'zapatillas/k0X0v4axBww2c1qfNnxFemavQXX6KGcoTV3XBpXN.jpg', 'imagenes_extra' => '[]', 'activo' => 1, 'destacado' => 0, 'created_at' => '2026-05-14 13:49:29', 'updated_at' => '2026-05-14 13:49:29'],
            ['id' => 11, 'categoria_id' => 4, 'nombre' => 'Basket Case', 'slug' => 'basket-case-e9c0l4', 'descripcion' => 'Simples y buen material.', 'marca' => 'Green Day', 'modelo' => 'Dookie', 'precio' => 95.99, 'imagen_principal' => 'zapatillas/gxZ0xL2xfNChvgmAYCOGXuKI2zhVIew6uRXESxqT.jpg', 'imagenes_extra' => '[]', 'activo' => 1, 'destacado' => 1, 'created_at' => '2026-05-14 13:51:20', 'updated_at' => '2026-05-14 13:52:29'],
            ['id' => 12, 'categoria_id' => 4, 'nombre' => 'Road to Revolution', 'slug' => 'road-to-revolution-llkljr', 'descripcion' => 'Elegantes y prácticas.', 'marca' => 'Linkin Park', 'modelo' => 'Hybrid', 'precio' => 88.99, 'imagen_principal' => 'zapatillas/Z7uKtVySW2sTFluoOgzHCX84xsS57GJI65yx0lzk.jpg', 'imagenes_extra' => '[]', 'activo' => 1, 'destacado' => 0, 'created_at' => '2026-05-14 13:54:01', 'updated_at' => '2026-05-14 13:54:01'],
            ['id' => 13, 'categoria_id' => 2, 'nombre' => 'Usaint Bolt +', 'slug' => 'usaint-bolt-jl4jy7', 'descripcion' => 'Para escapar de la poli.', 'marca' => 'Powderhorn', 'modelo' => 'Mineapolis', 'precio' => 25.05, 'imagen_principal' => 'zapatillas/TTuDnddwA3pcu3GXli1r1MHjZGSCvDjVPQwFQlgu.jpg', 'imagenes_extra' => '[]', 'activo' => 1, 'destacado' => 1, 'created_at' => '2026-05-14 13:57:02', 'updated_at' => '2026-05-14 13:57:02'],
            ['id' => 14, 'categoria_id' => 2, 'nombre' => 'Blue Bettle', 'slug' => 'blue-bettle-drlcif', 'descripcion' => 'Color azul cielo.', 'marca' => 'DC Comic', 'modelo' => 'Bettle', 'precio' => 55.97, 'imagen_principal' => 'zapatillas/rr0CTKvnmmAAT3pBCbA8MeAzkkAFgs3WqXYM59Xf.jpg', 'imagenes_extra' => '[]', 'activo' => 1, 'destacado' => 0, 'created_at' => '2026-05-14 13:58:42', 'updated_at' => '2026-05-14 13:58:42'],
            ['id' => 15, 'categoria_id' => 2, 'nombre' => 'Storm Running', 'slug' => 'storm-running-psnzez', 'descripcion' => 'Azul eléctrico.', 'marca' => 'Fortnite', 'modelo' => 'Storm', 'precio' => 250.00, 'imagen_principal' => 'zapatillas/DCbIiHq02CvpWuIl7I3Eci5L11xlQRYhfZcouKhk.jpg', 'imagenes_extra' => '[]', 'activo' => 1, 'destacado' => 0, 'created_at' => '2026-05-14 14:02:34', 'updated_at' => '2026-05-14 14:02:34'],
        ]);

        // 5. STOCK (Registros exactos)
        DB::table('tallas_stock')->insert([
            ['id' => 1, 'zapatilla_id' => 1, 'talla' => 41.0, 'stock' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'zapatilla_id' => 1, 'talla' => 42.0, 'stock' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'zapatilla_id' => 1, 'talla' => 38.0, 'stock' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'zapatilla_id' => 1, 'talla' => 39.0, 'stock' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'zapatilla_id' => 1, 'talla' => 40.0, 'stock' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'zapatilla_id' => 2, 'talla' => 38.0, 'stock' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'zapatilla_id' => 2, 'talla' => 39.0, 'stock' => 40, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'zapatilla_id' => 2, 'talla' => 40.0, 'stock' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'zapatilla_id' => 3, 'talla' => 40.0, 'stock' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'zapatilla_id' => 4, 'talla' => 39.0, 'stock' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'zapatilla_id' => 4, 'talla' => 40.0, 'stock' => 24, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'zapatilla_id' => 5, 'talla' => 40.0, 'stock' => 56, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'zapatilla_id' => 6, 'talla' => 39.0, 'stock' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'zapatilla_id' => 6, 'talla' => 40.0, 'stock' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 16, 'zapatilla_id' => 6, 'talla' => 41.0, 'stock' => 36, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 17, 'zapatilla_id' => 6, 'talla' => 42.0, 'stock' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 18, 'zapatilla_id' => 7, 'talla' => 44.0, 'stock' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 19, 'zapatilla_id' => 7, 'talla' => 43.0, 'stock' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 20, 'zapatilla_id' => 7, 'talla' => 45.0, 'stock' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 21, 'zapatilla_id' => 8, 'talla' => 43.0, 'stock' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 22, 'zapatilla_id' => 8, 'talla' => 44.0, 'stock' => 17, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 23, 'zapatilla_id' => 8, 'talla' => 45.0, 'stock' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 24, 'zapatilla_id' => 8, 'talla' => 46.0, 'stock' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 25, 'zapatilla_id' => 10, 'talla' => 37.0, 'stock' => 15, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 26, 'zapatilla_id' => 10, 'talla' => 38.0, 'stock' => 45, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 27, 'zapatilla_id' => 11, 'talla' => 36.0, 'stock' => 89, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 28, 'zapatilla_id' => 11, 'talla' => 38.0, 'stock' => 24, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 29, 'zapatilla_id' => 13, 'talla' => 20.0, 'stock' => 20, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 30, 'zapatilla_id' => 14, 'talla' => 37.0, 'stock' => 15, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 31, 'zapatilla_id' => 14, 'talla' => 38.0, 'stock' => 15, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 32, 'zapatilla_id' => 14, 'talla' => 39.0, 'stock' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 33, 'zapatilla_id' => 15, 'talla' => 40.0, 'stock' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 6. NOTICIAS
        DB::table('noticias')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'titulo' => 'NUEVAS CHANCLAS DEL VERANO',
                'slug' => 'nuevas-chanclas-del-verano-dpjfkl',
                'resumen' => '¿Te flipan las langostas?',
                'contenido' => '<p>Lanzamiento Lango-Chanclas.</p>',
                'imagen_portada' => 'noticias/lango.jpg',
                'categoria' => 'lanzamiento',
                'publicado' => 1,
                'publicado_en' => '2026-05-14 14:05:27',
                'destacado' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

    }
}
