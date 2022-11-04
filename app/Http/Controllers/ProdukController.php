<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $judul = 'Produk';
    protected $menu = 'datamaster';
    protected $sub_menu = 'produk';
    protected $direktori = 'admin.datamaster.produk';

    public function index()
    {
        $data['judul'] = $this->judul;
        $data['menu'] = $this->menu;
        $data['sub_menu'] = $this->sub_menu;
        $data['produk'] = Produk::with(['kategori_produk'])->orderBy('created_at', 'DESC')->get();

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

        $data['kategori_produk'] = KategoriProduk::all();

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
        $nama_produk = $request->nama_produk;
        $id_kategori_produk = $request->kategori_produk;
        $stok_produk = $request->stok;
        $berat_produk = $request->berat;
        $harga_produk = $request->harga;
        $deskripsi_produk = $request->deskripsi;
        $foto_produk = $request->foto;

        //pengecekan
        if(empty($nama_produk)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom Nama Produk Harus Diisi');
        }
        if(empty($id_kategori_produk)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom Kategori Produk Harus Diisi');
        }
        if(empty($stok_produk)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom Stok Produk Harus Diisi');
        }
        if(empty($berat_produk)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom Berat Produk Harus Diisi');
        }
        if(empty($harga_produk)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom Harga Produk Harus Diisi');
        }
        if(empty($deskripsi_produk)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom Deskripsi Produk Harus Diisi');
        }
        if(empty($foto_produk)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom Foto Produk Harus Diisi');
        }

        //simpan
        $produk = new Produk();
        $produk->nama_produk = $nama_produk;
        $produk->slug_produk = Str::slug($nama_produk);
        $produk->kategori_produk_id = $id_kategori_produk;
        $produk->stok_produk = $stok_produk;
        $produk->berat_produk = $berat_produk;
        $produk->harga_produk = $harga_produk;
        $produk->deskripsi_produk = $deskripsi_produk;

        $nama_foto = str_replace(['','/'],'-', $nama_produk);
        $ext_foto   = $foto_produk->getClientOriginalExtension();
        $filename   = $nama_foto ."-". date('Ymdhis') .".". $ext_foto;
        $tmp_foto   = 'img/produk';
        $proses     = $foto_produk->move($tmp_foto,$filename);
        
        $produk->foto_produk = $filename;
        $produk->save();

        if($produk){
            return redirect()->route('Produk')->with('status', 'success')->with('message', 'Berhasil disimpan');
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

        $data['kategori_produk'] = KategoriProduk::all();
        $data['produk'] = Produk::where('id_produk', $id)->first();

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

        $data['kategori_produk'] = KategoriProduk::all();
        $data['produk'] = Produk::where('id_produk', $id)->first();

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
        // return dd($request->all());
        $nama_produk = $request->nama_produk;
        $id_kategori_produk = $request->kategori_produk;
        $stok_produk = $request->stok;
        $berat_produk = $request->berat;
        $harga_produk = $request->harga;
        $deskripsi_produk = $request->deskripsi;
        $foto_produk = $request->foto_produk;

        //pengecekan
        if(empty($nama_produk)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom Nama Produk Harus Diisi');
        }
        if(empty($id_kategori_produk)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom Kategori Produk Harus Diisi');
        }
        if(empty($stok_produk)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom Stok Produk Harus Diisi');
        }
        if(empty($berat_produk)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom Berat Produk Harus Diisi');
        }
        if(empty($harga_produk)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom Harga Produk Harus Diisi');
        }
        if(empty($deskripsi_produk)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom Deskripsi Produk Harus Diisi');
        }

        //simpan
        $produk = Produk::where('id_produk', $id)->first();;
        $produk->nama_produk = $nama_produk;
        $produk->slug_produk = Str::slug($nama_produk);
        $produk->kategori_produk_id = $id_kategori_produk;
        $produk->stok_produk = $stok_produk;
        $produk->berat_produk = $berat_produk;
        $produk->harga_produk = $harga_produk;
        $produk->deskripsi_produk = $deskripsi_produk;

        if(isset($foto_produk)){
            if (!empty($foto_produk) && $foto_produk != '0') {
                if (!empty($produk) && $produk->foto_produk != '') {
                    $path = "img/produk/" . $produk->foto_produk;
                    if (file_exists($path)) {
                        unlink($path); //menghapus foto di direktori
                    }
                }
                $nama_foto = str_replace(['','/'],'-', $nama_produk);
                $ext_foto   = $foto_produk->getClientOriginalExtension();
                $filename   = $nama_foto ."-". date('Ymdhis') .".". $ext_foto;
                $tmp_foto   = 'img/produk';
                $proses     = $foto_produk->move($tmp_foto,$filename);
                
                $produk->foto_produk = $filename;
            }
        }

        
        $produk->save();

        if($produk){
            return redirect()->route('Produk')->with('status', 'success')->with('message', 'Berhasil disimpan');
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
        $produk = Produk::where('id_produk', $id)->first();
        if(!empty($produk)){
            if ($produk->foto_produk != '') {
                $path = "img/produk/" . $produk->foto_produk;
                if(file_exists($path)){
                    unlink($path);
                }
            }
            $produk->delete();

            return redirect()->route('Produk')->with('status', 'success')->with('message', 'Berhasil');
        }else{
            return redirect()->route('Produk')->with('status', 'error')->with('message', 'Gagal');
        }
    }

}
