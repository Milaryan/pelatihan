<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Provinsi;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $judul = 'Data User';
    protected $menu = 'datamaster';
    protected $sub_menu = 'datauser';
    protected $direktori = 'admin.datamaster.users';

    public function index()
    {
        $data['judul'] = $this->judul;
        $data['menu'] = $this->menu;
        $data['sub_menu'] = $this->sub_menu;
        $data['users'] = Users::where('level_user', 'Pengguna')->get();

        return view($this->direktori.'.datauser',$data);
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

        $data['provinsi'] = Provinsi::all();

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
        $nama_lengkap = $request->nama_lengkap;
        $username = $request->username;
        $email = $request->email;
        $password = $request->password;
        $no_telp = $request->no_telp;
        $provinsi_id = $request->provinsi;
        $kabupaten_id = $request->kabupaten;
        $kode_pos = $request->kode_pos;
        $alamat = $request->alamat;

        //pengecekan
        if(empty($nama_lengkap)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom Nama Lengkap Harus Diisi');
        }
        if(empty($username)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom email Harus Diisi');
        }
        if(empty($email)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom email Harus Diisi');
        }
        if(empty($password)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom password Harus Diisi');
        }
        if(empty($no_telp)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom No Telp Harus Diisi');
        }
        if(empty($provinsi_id)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom Provinsi Harus Diisi');
        }
        if(empty($kabupaten_id)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom Kabupaten Harus Diisi');
        }
        if(empty($kode_pos)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom Kode Pos Harus Diisi');
        }
        if(empty($alamat)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom Alamat Lengkap Harus Diisi');
        }

        $cek_username = Users::where('username', $username)->first();
        $cek_email = Users::where('email', $email)->first();

        if (!empty($cek_username)) {
            return back()->withInput()->with('status', 'error')->with('message', 'Username sudah terdaftar pada sistem');
        }
        if (!empty($cek_email)) {
            return back()->withInput()->with('status', 'error')->with('message', 'Alamat Email sudah terdaftar pada sistem');
        }

        //simpan
        $users = new Users();
        $users->nama_lengkap = $nama_lengkap;
        $users->username = $username;
        $users->email = $email;
        $users->password = Hash::make($password);
        $users->no_telp = $no_telp;
        $users->provinsi_id = $provinsi_id;
        $users->kabupaten_id = $kabupaten_id;
        $users->kode_pos = $kode_pos;
        $users->alamat_lengkap = $alamat;
        $users->level_user = "Pengguna";
        $users->save();

        if($users){
            return redirect()->route('users')->with('status', 'success')->with('message', 'Berhasil disimpan');
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

        $data['provinsi'] = Provinsi::all();
        $data['users'] = Users::where('id', $id)->first();

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

        $data['provinsi'] = Provinsi::all();
        $data['users'] = Users::where('id', $id)->first();

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
        $nama_lengkap = $request->nama_lengkap;
        $username = $request->username;
        $email = $request->email;
        $password = $request->password;
        $no_telp = $request->no_telp;
        $provinsi_id = $request->provinsi;
        $kabupaten_id = $request->kabupaten;
        $kode_pos = $request->kode_pos;
        $alamat = $request->alamat;

        //pengecekan
        if(empty($nama_lengkap)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom Nama Lengkap Harus Diisi');
        }
        if(empty($username)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom email Harus Diisi');
        }
        if(empty($email)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom email Harus Diisi');
        }
        // if(empty($password)){
        //     return back()->withInput()->with('status', 'error')->with('message', 'Kolom password Harus Diisi');
        // }
        if(empty($no_telp)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom No Telp Harus Diisi');
        }
        if(empty($provinsi_id)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom Provinsi Harus Diisi');
        }
        if(empty($kabupaten_id)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom Kabupaten Harus Diisi');
        }
        if(empty($kode_pos)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom Kode Pos Harus Diisi');
        }
        if(empty($alamat)){
            return back()->withInput()->with('status', 'error')->with('message', 'Kolom Alamat Lengkap Harus Diisi');
        }

        $cek_username = Users::where('username', $username)->where('id', '!=', $id)->first();
        $cek_email = Users::where('email', $email)->where('id', '!=', $id)->first();

        if (!empty($cek_username)) {
            return back()->withInput()->with('status', 'error')->with('message', 'Username sudah terdaftar pada sistem');
        }
        if (!empty($cek_email)) {
            return back()->withInput()->with('status', 'error')->with('message', 'Alamat Email sudah terdaftar pada sistem');
        }

        //simpan
        $users = Users::where('id', $id)->first();
        $users->nama_lengkap = $nama_lengkap;
        $users->username = $username;
        $users->email = $email;
        if(!empty($password)){
            $users->password = Hash::make($password);
        }
        $users->no_telp = $no_telp;
        $users->provinsi_id = $provinsi_id;
        $users->kabupaten_id = $kabupaten_id;
        $users->kode_pos = $kode_pos;
        $users->alamat_lengkap = $alamat;
        $users->level_user = "Pengguna";
        $users->save();

        if($users){
            return redirect()->route('users')->with('status', 'success')->with('message', 'Berhasil disimpan');
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
        $users = Users::where('id', $id)->first();
        if(!empty($users)){
            $users->delete();

            return redirect()->route('users')->with('status', 'success')->with('message', 'Berhasil');
        }else{
            return redirect()->route('users')->with('status', 'error')->with('message', 'Gagal');
        }
    }

    public function getKabupaten(Request $request){
        $kabupaten = Kabupaten::where('id_provinsi', $request->id_provinsi)->get();

        if ($kabupaten->count()>0) {
            return ['status' => 'success', 'code' => 200, 'message' => 'Berhasil mengambil data', 'data' => $kabupaten];
        }else{
            return ['status' => 'error', 'code' => 500, 'message' => 'Gagal mengambil data', 'data' => $kabupaten];
        }
    }
}
