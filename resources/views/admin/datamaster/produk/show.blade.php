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
                  <h3 class="card-title">Detail {{ $judul }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form>
                    @csrf
                  <div class="card-body">
                    <div class="form-group">
                      <label for="nama_produk">Nama Produk</label>
                      <input type="text" name="nama_produk" class="form-control" id="nama_produk" placeholder="Masukkan nama produk" value="{{old('nama_produk') ? old('nama_produk') : $produk->nama_produk }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="kategori_produk">Kategori Produk</label>
                        <select name="kategori_produk" id="kategori_produk" class="form-control" disabled>
                        <option value="">.:: Pilih Kategori Produk ::.</option>
                          @foreach($kategori_produk as $key => $prov)
                          <option value="{{ ($prov->id_kategori_produk) }}" {{($prov->id_kategori_produk == $produk->kategori_produk_id) ? 'selected' : ''}}>{{ $prov->nama_kategori_produk }}</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="stok">Stok Produk</label>
                      <input type="text" name="stok" class="form-control" id="stok" placeholder="Masukkan Stok Produk" value="{{old('stok') ? old('stok') : $produk->stok_produk}}" disabled>
                    </div>
                    <div class="form-group">
                      <label for="berat">Berat Produk (gram)</label>
                      <input type="berat" name="berat" class="form-control" id="berat" placeholder="Masukkan Berat Produk" value="{{old('berat') ? old('berat') : $produk->berat_produk}}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga Produk</label>
                        <input type="text" name="harga" class="form-control" id="harga" placeholder="Masukkan Harga Produk" value="{{old('harga') ? old('harga') : $produk->harga_produk }}" disabled>
                    </div>
                    <div class="form-group">
                      <label for="deskripsi">Deskripsi Produk</label>
                      <textarea name="deskripsi" id="deskripsi" class="form-control" cols="30" rows="3" placeholder="Masukkan Deskripsi Produk" disabled>{{old('deskripsi') ? old('deskripsi') : $produk->deskripsi_produk}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto Produk</label>
                        <input type="text" name="foto" class="form-control" id="foto" placeholder="Masukkan Foto Produk" value="{{old('foto') ? old('foto') : $produk->foto_produk }}" disabled>
                    </div>
                    <div class="form-group">
                      <div class="card">
                        <div class="card-body">
                          <img src="{{ asset('img/produk') }}/{{ $produk->foto_produk }}" width="200" alt="">
                        </div>
                      </div>
                    </div>

  
                  <div class="card-footer">
                    {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                    <a href="{{ route('Produk') }}" class="btn btn-primary btn-md">Kembali</a>
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
