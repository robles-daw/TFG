<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\DescuentoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockAlertSubscriptionController;
use App\Http\Controllers\TallaStockController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ZapatillaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::resource('categorias', CategoriaController::class)->only(['index', 'show']);
Route::resource('zapatillas', ZapatillaController::class)->only(['index', 'show']);

Route::get('/noticias', [NoticiaController::class, 'index'])->name('noticias.index');
Route::get('/noticias/{slug}', [NoticiaController::class, 'show'])->name('noticias.show');

Route::get('/contactos', [ContactoController::class, 'index'])->name('contacto.index');
Route::post('/contactos', [ContactoController::class, 'store'])->name('contacto.store');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/perfil', [ProfileController::class, 'index'])->name('perfil.index');
    Route::get('/mis-pedidos', [PedidoController::class, 'misPedidos'])->name('pedidos.mis_pedidos');
    Route::get('/pedidos/{pedido}', [PedidoController::class, 'show'])->name('pedidos.show');

    // Carrito
    Route::get('/carrito', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/carrito/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::post('/carrito/remove', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::post('/carrito/update', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::post('/carrito/coupon', [App\Http\Controllers\CartController::class, 'applyCoupon'])->name('cart.coupon.apply');
    Route::post('/carrito/coupon/remove', [App\Http\Controllers\CartController::class, 'removeCoupon'])->name('cart.coupon.remove');
    Route::post('/zapatillas/{zapatilla}/avisos-stock', [StockAlertSubscriptionController::class, 'store'])->name('stock-alerts.store');

    // Checkout
    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('categorias', CategoriaController::class)->except(['show']);
    Route::resource('zapatillas', ZapatillaController::class)->except(['show']);
    Route::resource('descuentos', DescuentoController::class)->except(['show']);
    Route::resource('users', UserController::class)->except(['show']);

    Route::post('zapatillas/{zapatilla}/tallas', [TallaStockController::class, 'store'])->name('tallas.store');
    Route::delete('tallas/{tallaStock}', [TallaStockController::class, 'destroy'])->name('tallas.destroy');

    Route::get('pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::put('pedidos/{pedido}/estado', [PedidoController::class, 'updateEstado'])->name('pedidos.updateEstado');

    Route::get('noticias', [NoticiaController::class, 'backendIndex'])->name('noticias.index');
    Route::get('noticias/create', [NoticiaController::class, 'create'])->name('noticias.create');
    Route::post('noticias', [NoticiaController::class, 'store'])->name('noticias.store');
    Route::get('noticias/{noticia}/edit', [NoticiaController::class, 'edit'])->name('noticias.edit');
    Route::put('noticias/{noticia}', [NoticiaController::class, 'update'])->name('noticias.update');
    Route::delete('noticias/{noticia}', [NoticiaController::class, 'destroy'])->name('noticias.destroy');
});
