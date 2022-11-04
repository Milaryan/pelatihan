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
                <form method="post" action="{{ route('kategoriProdukUpdate', $kategori_produk->id_kategori_produk) }}">
                    @csrf
                  <div class="card-body">
                    <div class="form-group">
                      <label for="nama_kategori_produk">Nama Kategori Produk</label>
                      <input type="text" name="nama_kategori_produk" class="form-control" id="nama_kategori_produk" placeholder="Masukkan Nama Kategori Produk" value="{{ old('nama_kategori_produk') ? old('nama_kategori_produk') : $kategori_produk->nama_kategori_produk }}"" required>
                    </div>
  
                  <div class="card-footer">
                    <a href="{{ route('kategoriProduk') }}" class="btn btn-secondary btn-md">Kembali</a>
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
