<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\KategoriProduk;
use App\Models\Keranjang;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $judul = 'Dashboard';
    protected $menu = 'dashboard';
    protected $sub_menu = '';
    protected $direktori = 'user';

    public function main(Request $request)
    {
        $data['judul'] = $this->judul;
        $data['menu'] = $this->menu;
        $data['sub_menu'] = $this->sub_menu;

        $data['kategori_produk'] = KategoriProduk::with('produk')->get();
        $data['produk'] = Produk::with('kategori_produk')->get();

        return view($this->direktori.'.index',$data);
    }

    public function addTochart(Request $request){
        $id = $request->id;
        // Check dulu dikranjang
        // ada produk yg sama atau tidak
        if (Auth::check()) {
            $check_keranjang = Keranjang::where('produk_id', $id)
                                        ->where('user_id', Auth::id())
                                        ->first();
            if ($check_keranjang) {
                $check_keranjang->qty = $check_keranjang->qty + 1;
            }else{
                $check_keranjang = new Keranjang();
                $check_keranjang->produk_id = $id;
                $check_keranjang->qty = 1;
                $check_keranjang->user_id = Auth::id();
            }
            $check_keranjang->save();

            if ($check_keranjang) {
                return redirect()->route('userDashboard')->with('status', 'success')->with('message', 'Berhasil ditambahkan ke keranjang');
            }else{
                return redirect()->route('userDashboard')->with('status', 'error')->with('message', 'Gagal ditambahkan ke keranjang');
            }
        }else{
            return redirect()->route('userDashboard')->with('status', 'error')->with('message', 'Anda belum login!!!');
        }
    }

    public function removeTochart(Request $request){
        $id = $request->id;
        // Check dulu dikranjang
        // ada produk yg sama atau tidak
        if (Auth::check()) {
            $check_keranjang = Keranjang::where('produk_id', $id)
                                        ->where('user_id', Auth::id())
                                        ->first();
            if ($check_keranjang) {
                $check_keranjang->qty = $check_keranjang->qty + 1;
            }else{
                $check_keranjang = new Keranjang();
                $check_keranjang->produk_id = $id;
                $check_keranjang->qty = 1;
                $check_keranjang->user_id = Auth::id();
            }
            $check_keranjang->delete();

            if ($check_keranjang) {
                return redirect()->route('userDashboard')->with('status', 'success')->with('message', 'Berhasil Menghapus ke keranjang');
            }else{
                return redirect()->route('userDashboard')->with('status', 'error')->with('message', 'Gagal Menghapus ke keranjang');
            }
        }else{
            return redirect()->route('userDashboard')->with('status', 'error')->with('message', 'Anda belum login!!!');
        }
    }

    public function history(Request $request){
        if (Auth::check()) {
            $data['judul'] = $this->judul;
            $data['menu'] = $this->menu;
            $data['sub_menu'] = $this->sub_menu;
            
            $data['transaksi'] = Transaksi::with('users')
                                        ->with('provinsi')
                                        ->with('kabupaten')
                                        ->with('transaksi_detail')
                                        ->with('transaksi_detail.produk')
                                        ->where('user_id', Auth::id())->get();
        
            $data['kategori_produk'] = KategoriProduk::with('produk')->get();
            

            return view($this->direktori.'.history', $data);
        }else{
            return redirect()->route('userDashboard')
                            ->with('status', 'error')
                            ->with('message', 'Anda Belum Login');
        }
    }
}
