<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Users;
use App\Models\Produk;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $judul = 'Data Detail Transaksi';
    protected $menu = 'transaksi';
    protected $sub_menu = '';
    protected $direktori = 'admin.datamaster.transaksi';

    public function index()
    {
        $data['judul'] = $this->judul;
        $data['menu'] = $this->menu;
        $data['sub_menu'] = $this->sub_menu;

        $data['transaksi'] = Transaksi::with(['users'])->orderBy('created_at', 'DESC')->get();

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

        $data['users'] = Users::where('level_user', 'Pengguna')->get();
        $data['produk'] = Produk::with(['kategori_produk'])->get();

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
        $user_id = $request->user_id;
        $produk_id = $request->produk_id;
        $tgl = $request->tgl;
        $ekspedisi = $request->ekspedisi;
        $status = $request->status;
        $catatan = $request->catatan_pembeli;

        //pengecekan
        if(empty($user_id)){
            return back()->withInput()->with('status', 'error')->with('message', 'Pilih Pengguna');
        }
        if(empty($produk_id)){
            return back()->withInput()->with('status', 'error')->with('message', 'Pilih Produk');
        }
        if(empty($tgl)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom Tanggal Harus Diisi');
        }
        if(empty($ekspedisi)){
            return back()->withInput()->with('status', 'error')->with('message', 'Pilih Ekspedisi');
        }
        if(empty($status)){
            return back()->withInput()->with('status', 'error')->with('message', 'Pilih Status');
        }
        if(empty($catatan)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom Catatan Harus Diisi');
        }

        $users = Users::where('id', $user_id)->first();
        $transaksi = Transaksi::orderBy('id_transaksi', 'DESC')->first();
        if (empty($transaksi)) {
            $kode_transaksi = 'TR-0001';
        } else {
            $kode_transaksi = 'TR-000'. ((int)substr($transaksi->kode_transaksi, 6)+1);
        }
        
        
        //simpan
        $transaksi = new Transaksi();
        $transaksi->kode_transaksi = $kode_transaksi;
        $transaksi->kode_invoice = '-';

        $transaksi->user_id = $user_id;
        $transaksi->tanggal_transaksi = date('Y-m-d', strtotime($tgl));
        $transaksi->status_transaksi = $status;

        $transaksi->provinsi_id = $users->provinsi_id;
        $transaksi->kabupaten_id = $users->kabupaten_id;
        $transaksi->kode_pos = $users->kode_pos;
        $transaksi->alamat_lengkap = $users->alamat_lengkap;
        
        $transaksi->ekspedisi = $ekspedisi;
        $transaksi->catatan_pembeli = $catatan;
        $transaksi->save();

        if($transaksi){
            $transaksi = Transaksi::where('id_transaksi', $transaksi->id_transaksi)->first();
            $transaksi->kode_invoice = date('dmY') . '' . $transaksi->id_transaksi;
            $transaksi->save();
            
            $transaksi_detail = new TransaksiDetail();
            $transaksi_detail->transaksi_id = $transaksi->id_transaksi;
            $transaksi_detail->produk_id = $produk_id;
            $transaksi_detail->qty = 1;
            $transaksi_detail->save();
            
            if($transaksi_detail){
                $produk = Produk::where('id_produk', $produk_id)->first();
                $produk->stok_produk = ($produk->stok_produk - 1);
                $produk->save();
            }

        }

        if($transaksi){
            return redirect()->route('Transaksi')->with('status', 'success')->with('message', 'Berhasil disimpan');
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

            $data['transaksi'] = Transaksi::with(['users',
            'provinsi',
            'kabupaten',
            'transaksi_detail' => function($td){
                $td->with(['produk']);
            } 
        ])->where('id_transaksi', $id)->first();

        $data['total_jumlah_transaksi'] = Transaksi::selectRaw("SUM(p.harga_produk*td.qty) as jumlah")
        ->join('transaksi_detail as td', 'td.transaksi_id', 'transaksi.id_transaksi')
        ->join('produk as p', 'p.id_produk', 'td.produk_id')
        ->where('id_transaksi', $id)
        ->first()->jumlah;

        return view($this->direktori.'.show',$data);
    }
    
    public function tolak($id){
        $transaksi = Transaksi::where('id_transaksi', $id)->first();
        if(!empty($transaksi)){
            if ($transaksi->status_transaksi == 'Pending' || $transaksi->status_transaksi == 'Selesai') {
                $transaksi->status_transaksi = 'Tolak';
                $transaksi->save();

                if ($transaksi) {
                    $transaksi_detail = TransaksiDetail::where('transaksi_id', $transaksi->id_transaksi)->get();

                    foreach($transaksi_detail as $key => $td){
                        $produk = Produk::where('id_produk', $td->produk_id)->first();
                        $produk->stok_produk = ($produk->stok_produk - $td->qty);
                        $produk->save();
                    }
                    return redirect()->route('Transaksi')->with('status', 'success')->with('message', 'Berhasil ditolak');
                }else {
                    return redirect()->route('Transaksi')->with('status', 'error')->with('message', 'Gagal ditolak');
                }
            }else {
                return redirect()->route('Transaksi')->with('status', 'error')->with('message', 'Transaksi Tidak Sesuai');
            }
        }else {
            return redirect()->route('Transaksi')->with('status', 'error')->with('message', 'Gagal Menolak');
        }
    }

    public function proses($id)
    {
        $transaksi = Transaksi::where('id_transaksi', $id)->first();
        if(!empty($transaksi)){
            if ($transaksi->status_transaksi == 'Pending') {
                $transaksi->status_transaksi = 'Proses Admin';
                $transaksi->kode_invoice = date('dmY').''.$transaksi->id_transaksi;
                $transaksi->save();

                if($transaksi){
                    return redirect()->route('Transaksi')->with('status', 'success')->with('message', 'Berhasil Memproses');
                }else{
                    return redirect()->route('Transaksi')->with('status', 'error')->with('message', 'Gagal Memproses');
                }
            }else{
                return redirect()->route('Transaksi')->with('status', 'error')->with('message', 'Status Transaksi Tidak Sesuai');
            }
        }else{
            return redirect()->route('Transaksi')->with('status', 'error')->with('message', 'Gagal Memproses Transaksi');
        }
    }

    public function kirim($id)
    {
        $transaksi = Transaksi::where('id_transaksi', $id)->first();
        if (!empty($transaksi)) {
            if ($transaksi->status_transaksi == 'Proses Admin') {
                $transaksi->status_transaksi = 'Pengiriman';
                $transaksi->save();

                if($transaksi){
                    return redirect()->route('Transaksi')->with('status', 'success')->with('message', 'Berhasil Mengirim');
                }else{
                    return redirect()->route('Transaksi')->with('status', 'error')->with('message', 'Gagal Mengirim');
                }
            }else{
                return redirect()->route('Transaksi')->with('status', 'error')->with('message', 'Status Transaksi Tidak Sesuai');
            }
        }else{
            return redirect()->route('Transaksi')->with('status', 'error')->with('message', 'Gagal Mengirim Transaksi');
        }
    }

    public function selesai($id)
    {
        $transaksi = Transaksi::where('id_transaksi', $id)->first();
        if (!empty($transaksi)) {
            if ($transaksi->status_transaksi == 'Pengiriman') {
                $transaksi->status_transaksi = 'Selesai';
                $transaksi->save();

                if($transaksi){
                    return redirect()->route('Transaksi')->with('status', 'success')->with('message', 'Berhasil Menyelesaikan');
                }else{
                    return redirect()->route('Transaksi')->with('status', 'error')->with('message', 'Gagal Menyelesaikan');
                }
            }else{
                return redirect()->route('Transaksi')->with('status', 'error')->with('message', 'Status Transaksi Tidak Sesuai');
            }
        }else{
            return redirect()->route('Transaksi')->with('status', 'error')->with('message', 'Gagal MenyelesaikanTransaksi');
        }
    }
}