<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanPenjualanController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\CheckoutController as UserCheckoutController;
use App\Http\Controllers\User\ProdukController as UserProdukController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('userDashboard');
});
Route::get('/index', [UserDashboardController::class, 'main'])->name('userDashboard');
Route::post('/addTochart', [UserDashboardController::class, 'addTochart'])->name('userAddToChart');
Route::post('/removeTochart', [UserDashboardController::class, 'removeTochart'])->name('userRemoveToChart');
Route::post('/checkout', [UserCheckoutController::class, 'main'])->name('userCheckout');
Route::post('/checkoutProses', [UserCheckoutController::class, 'proses'])->name('userCheckoutProses');
Route::post('/checkoutComplete',[UserCheckoutController::class, 'complete'])->name('userCheckoutComplete');
Route::get('/produk/{slug}', [UserProdukController::class,'main'])->name('userProduk');
Route::get('/checkoutHistory', [UserDashboardController::class,'history'])->name('userHistory');


Route::group(['prefix' => 'admin'], function(){
    Route::get('/', function(){
        return redirect()->route('dashboard');
    });
    
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/postLogin', [AuthController::class, 'postLogin'])->name('postLogin');
    Route::get('/logout',[AuthController::class, 'logout'])->name('logout');

    Route::group(['middleware' => ['checklogin']], function(){
        Route::get('/dashboard', [DashboardController::class, 'main'])->name('dashboard');

        Route::group(['prefix' => 'datamaster'], function(){
            Route::group(['prefix' => 'users'], function(){
                Route::get('/',[UsersController::class, 'index'])->name('users');
                Route::get('/create',[UsersController::class, 'create'])->name('usersCreate');
                Route::post('/store',[UsersController::class, 'store'])->name('usersStore');
                Route::get('/show/{id}',[UsersController::class, 'show'])->name('usersShow');
                Route::get('/edit/{id}',[UsersController::class, 'edit'])->name('usersEdit');
                Route::post('/update/{id}',[UsersController::class, 'update'])->name('usersUpdate');
                Route::get('/delete/{id}',[UsersController::class, 'destroy'])->name('usersDelete');

                Route::post('/getKabupaten', [UsersController::class, 'getKabupaten'])->name('usersGetKabupaten');
            });

                Route::group(['prefix' => 'kategori_produk'], function(){
                Route::get('/',[KategoriProdukController::class, 'index'])->name('kategoriProduk');
                Route::get('/create',[KategoriProdukController::class, 'create'])->name('kategoriProdukCreate');
                Route::post('/store',[KategoriProdukController::class, 'store'])->name('kategoriProdukStore');
                Route::get('/show/{id}',[KategoriProdukController::class, 'show'])->name('kategoriProdukShow');
                Route::get('/edit/{id}',[KategoriProdukController::class, 'edit'])->name('kategoriProdukEdit');
                Route::post('/update/{id}',[KategoriProdukController::class, 'update'])->name('kategoriProdukUpdate');
                Route::get('/delete/{id}',[KategoriProdukController::class, 'destroy'])->name('kategoriProdukDelete');
            });

                Route::group(['prefix' => 'produk'], function(){
                Route::get('/',[ProdukController::class, 'index'])->name('Produk');
                Route::get('/create',[ProdukController::class, 'create'])->name('ProdukCreate');
                Route::post('/store',[ProdukController::class, 'store'])->name('ProdukStore');
                Route::get('/show/{id}',[ProdukController::class, 'show'])->name('ProdukShow');
                Route::get('/edit/{id}',[ProdukController::class, 'edit'])->name('ProdukEdit');
                Route::post('/update/{id}',[ProdukController::class, 'update'])->name('ProdukUpdate');
                Route::get('/delete/{id}',[ProdukController::class, 'destroy'])->name('ProdukDelete');
            });

            Route::group(['prefix' => 'transaksi'], function(){
                Route::get('/',[TransaksiController::class, 'index'])->name('Transaksi');
                Route::get('/create',[TransaksiController::class, 'create'])->name('TransaksiCreate');
                Route::post('/store',[TransaksiController::class, 'store'])->name('TransaksiStore');
                Route::get('/show/{id}',[TransaksiController::class, 'show'])->name('TransaksiShow');
                Route::get('/edit/{id}',[TransaksiController::class, 'edit'])->name('TransaksiEdit');
                Route::post('/update/{id}',[TransaksiController::class, 'update'])->name('TransaksiUpdate');
                Route::get('/delete/{id}',[TransaksiController::class, 'destroy'])->name('TransaksiDelete');

                Route::get('/tolak/{id}',[TransaksiController::class, 'tolak'])->name('transaksiTolak');
                Route::get('/proses/{id}',[TransaksiController::class, 'proses'])->name('transaksiProses');
                Route::get('/kirim/{id}',[TransaksiController::class, 'kirim'])->name('transaksiKirim');
                Route::get('/selesai/{id}',[TransaksiController::class, 'selesai'])->name('transaksiSelesai');
            });

            Route::group(['prefix' => 'laporan'], function(){
                Route::group(['prefix' => 'laporan_penjualan'], function(){
                    Route::get('/', [LaporanPenjualanController::class, 'index'])->name('laporanPenjualan');
                    Route::get('/print', [LaporanPenjualanController::class, 'print'])->name('laporanPenjualanPrint');
                });
            });
        }); 
    });
});
