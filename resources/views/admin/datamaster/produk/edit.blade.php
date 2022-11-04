@extends('admin.part.main')

@section('container')

<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12 mt-4">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Edit {{ $judul }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post" action="{{ route('ProdukUpdate', $produk->id_produk) }}" enctype="multipart/form-data">
                    @csrf
                  <div class="card-body">
                    <div class="form-group">
                      <label for="nama_produk">Nama Produk</label>
                      <input type="text" name="nama_produk" class="form-control" id="nama_produk" placeholder="Masukkan nama produk" value="{{old('nama_produk') ? old('nama_produk') : $produk->nama_produk }}" required>
                    </div>
                    <div class="form-group">
                        <label for="kategori_produk">Kategori Produk</label>
                        <select name="kategori_produk" id="kategori_produk" class="form-control" onchange="getKabupaten()" required>
                        <option value="">.:: Pilih Kategori Produk ::.</option>
                            @foreach($kategori_produk as $key => $prov)
                            <option value="{{ ($prov->id_kategori_produk) }}" {{($prov->id_kategori_produk == $produk->kategori_produk_id) ? 'selected' : ''}}>{{ $prov->nama_kategori_produk }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="stok">Stok Produk</label>
                      <input type="text" name="stok" class="form-control" id="stok" placeholder="Masukkan stok" value="{{old('stok') ? old('stok') : $produk->stok_produk}}" required>
                    </div>
                    <div class="form-group">
                        <label for="berat">Berat Produk (gram)</label>
                        <input type="text" name="berat" class="form-control" id="berat" placeholder="Masukkan no telp" value="{{old('berat') ? old('berat') : $produk->berat_produk }}" required>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga Produk</label>
                        <input type="text" name="harga" class="form-control" id="harga" placeholder="Masukkan Kode Pos" value="{{old('harga') ? old('harga') : $produk->harga_produk }}" required>
                    </div>
                    <div class="form-group">
                      <label for="deskripsi">Deskripsi Produk</label>
                      <textarea name="deskripsi" id="deskripsi" class="form-control" cols="30" rows="3" placeholder="Masukkan deskripsi" required>{{old('deskripsi') ? old('deskripsi') : $produk->deskripsi_produk}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="foto_produk">Foto Produk</label>
                        <input type="file" name="foto_produk" class="form-control" id="foto_produk" placeholder="Pilih Foto Produk" value="{{old('foto_produk') ? old('foto_produk') : $produk->foto_produk }}">
                    </div>
                    <div class="form-group">
                      <div class="card">
                        <div class="card-body">
                          <img src="{{ asset('img/produk') }}/{{ $produk->foto_produk }}" width="200" alt="">
                        </div>
                      </div>
                    </div>
                    
                  <div class="card-footer">
                    <a href="{{ route('Produk') }}" class="btn btn-secondary btn-md">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
                </form>
              </div>
              <!-- /.card -->
            </div>
            <!--/.col (left) -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
</div>

@endsection
