<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $judul = 'Kategori Produk';
    protected $menu = 'datamaster';
    protected $sub_menu = 'kategori_produk';
    protected $direktori = 'admin.datamaster.kategori_produk';

    public function index()
    {
        $data['judul'] = $this->judul;
        $data['menu'] = $this->menu;
        $data['sub_menu'] = $this->sub_menu;
        $data['kategori_produk'] = KategoriProduk::orderBy('created_at', 'DESC')->get();

        return view($this->direktori.'.main',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['judul'] = $this->judul;
        $data['menu'] = $this->menu;
        $data['sub_menu'] = $this->sub_menu;

        return view($this->direktori.'.add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nama_kategori_produk = $request->nama_kategori_produk;

        //pengecekan
        if(empty($nama_kategori_produk)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom Nama Kategori Harus Diisi');
        }

        $cek_kategori_produk = KategoriProduk::where('nama_kategori_produk', $nama_kategori_produk)->first();

        if (!empty($cek_kategori_produk)) {
            return back()->withInput()->with('status', 'error')->with('message', 'Kategori Produk sudah terdaftar pada sistem');
        }

        //simpan
        $KategoriProduk = new KategoriProduk();
        $KategoriProduk->nama_kategori_produk = $nama_kategori_produk;
        $KategoriProduk->slug_kategori_produk = Str::slug($nama_kategori_produk);
        $KategoriProduk->save();

        if($KategoriProduk){
            return redirect()->route('kategoriProduk')->with('status', 'success')->with('message', 'Berhasil disimpan');
        }else{
            return back()->withInput()->with('status', 'error')->with('message', 'Gagal disimpan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['judul'] = $this->judul;
        $data['menu'] = $this->menu;
        $data['sub_menu'] = $this->sub_menu;

        $data['kategori_produk'] = KategoriProduk::where('id_kategori_produk', $id)->first();

        return view($this->direktori.'.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['judul'] = $this->judul;
        $data['menu'] = $this->menu;
        $data['sub_menu'] = $this->sub_menu;

        $data['kategori_produk'] = KategoriProduk::where('id_kategori_produk', $id)->first();

        return view($this->direktori.'.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $nama_kategori_produk = $request->nama_kategori_produk;

        //pengecekan
        if(empty($nama_kategori_produk)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom Nama Kategori Produk Harus Diisi');
        }

        $cek_kategori_produk = KategoriProduk::where('nama_kategori_produk', $nama_kategori_produk)->where('id_kategori_produk', '!=', $id)->first();

        if (!empty($cek_kategori_produk)) {
            return back()->withInput()->with('status', 'error')->with('message', 'Kategori Produk sudah terdaftar pada sistem');
        }

        //simpan
        $KategoriProduk = KategoriProduk::where('id_kategori_produk', $id)->first();
        $KategoriProduk->nama_kategori_produk = $nama_kategori_produk;
        $KategoriProduk->slug_kategori_produk = Str::slug($nama_kategori_produk);
        $KategoriProduk->save();

        if($KategoriProduk){
            return redirect()->route('kategoriProduk')->with('status', 'success')->with('message', 'Berhasil disimpan');
        }else{
            return back()->withInput()->with('status', 'error')->with('message', 'Gagal disimpan');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $KategoriProduk = KategoriProduk::where('id_kategori_produk', $id)->first();
        if(!empty($KategoriProduk)){
            $KategoriProduk->delete();

            return redirect()->route('kategoriProduk')->with('status', 'success')->with('message', 'Berhasil');
        }else{
            return redirect()->route('kategoriProduk')->with('status', 'error')->with('message', 'Gagal');
        }
    }

}
