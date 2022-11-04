<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kabupaten;
use App\Models\Keranjang;
use App\Models\Produk;
use App\Models\Provinsi;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\KategoriProduk;
use App\Models\Users;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    protected $judul = 'Checkout';
    protected $menu = 'checkout';
    protected $sub_menu = '';
    protected $direktori = 'user.checkout';

    public function main(Request $request){
        $id = $request->id;

        $data['judul'] = $this->judul;
        $data['menu'] = $this->menu;
        $data['sub_menu'] = $this->sub_menu;

        $data['keranjang'] = Keranjang::find($id);
        $data['user'] = Users::find($data['keranjang']->user_id);
        $data['kabupaten'] = Kabupaten::find($data['user']->kabupaten_id);
        $data['provinsi'] = Provinsi::find($data['user']->provinsi_id);
        $data['produk'] = Produk::with('kategori_produk')->find($data['keranjang']->produk_id);
        $data['kategori_produk'] = KategoriProduk::with('produk')->get();

        return view($this->direktori.'.main',$data);
    }

    public function proses(Request $request){
        $id_user = $request->id_user;
        $id_keranjang = $request->id_keranjang;
        $tanggal_transaksi = date('Y-m-d');
        $ekspedisi = $request->pengiriman;
        $catatan_pembeli = $request->catatan_pembeli;

        // pengecekan
        if (empty($id_user)) {
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom pembeli harus diisi');
        }
        if (empty($id_keranjang)) {
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom keranjang harus diisi');
        }
        if (empty($tanggal_transaksi)) {
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom tanggal transaksi harus diisi');
        }
        if (empty($ekspedisi)) {
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom ekspedisi harus diisi');
        }
        if (empty($catatan_pembeli)) {
            $catatan_pembeli = '-';
        }

        $users = Users::find($id_user);
        $transaksi = Transaksi::orderBy('id_transaksi', 'DESC')->first();
        if (empty($transaksi)) {
            $kode_transaksi = 'TR-0001';
        } else {
            $kode_transaksi = 'TR-000'. ((int)substr($transaksi->kode_transaksi, 6)+1);
        }
        $keranjang = Keranjang::find($id_keranjang);

        //simpan
        $transaksi = new Transaksi();
        $transaksi->kode_transaksi = $kode_transaksi;
        $transaksi->kode_invoice = '-';

        $transaksi->user_id = $id_user;
        $transaksi->tanggal_transaksi = date('Y-m-d', strtotime($tanggal_transaksi));
        $transaksi->status_transaksi = 'Pending';

        $transaksi->provinsi_id = $users->provinsi_id;
        $transaksi->kabupaten_id = $users->kabupaten_id;
        $transaksi->kode_pos = $users->kode_pos;
        $transaksi->alamat_lengkap = $users->alamat_lengkap;
        
        $transaksi->ekspedisi = $ekspedisi;
        $transaksi->catatan_pembeli = $catatan_pembeli;
        $transaksi->save();

        if($transaksi){
            $transaksi = Transaksi::where('id_transaksi', $transaksi->id_transaksi)->first();
            $transaksi->kode_invoice = date('dmY') . '' . $transaksi->id_transaksi;
            $transaksi->save();
            
            $transaksi_detail = new TransaksiDetail();
            $transaksi_detail->transaksi_id = $transaksi->id_transaksi;
            $transaksi_detail->produk_id = $keranjang->produk_id;
            $transaksi_detail->qty = $keranjang->qty;
            $transaksi_detail->save();
            
            if($transaksi_detail){
                $produk = Produk::where('id_produk', $keranjang->produk_id)->first();
                $produk->stok_produk = ($produk->stok_produk - 1);
                $produk->save();
            }
        }

        if($transaksi){
            $keranjang->delete();
            return redirect()->route('userDashboard')->with('status', 'success')->with('message', 'Berhasil disimpan');
        }else{
            return back()->withInput()->with('status', 'error')->with('message', 'Gagal disimpan');
        }
    }

    public function complete(Request $request){
        $id = $request->id;
        $get_checkout = Transaksi::find($id);

        if($get_checkout){
            $get_checkout->status_transaksi = 'Selesai';
            $get_checkout->save();

            if ($get_checkout) {
                return redirect()->route('userHistory')->with('status', 'success')->with('message', 'Berhasil mengubah status menjadi selesai');
            }else{
                return redirect()->route('userHistory')->with('status', 'error')->with('message', 'Gagal mengubah status menjadi selesai');
            }
        }else{
            return redirect()->route('userHistory')->with('status', 'error')->with('message', 'Gagal mengubah status');
        }
    }
}
