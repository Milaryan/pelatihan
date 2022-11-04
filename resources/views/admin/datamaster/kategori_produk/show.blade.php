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
                      <label for="nama_kategori_produk">Nama Kategori Produk</label>
                      <input type="text" name="nama_kategori_produk" class="form-control" id="nama_kategori_produk" placeholder="Masukkan nama Kategori Produk" value="{{old('nama_kategori_produk') ? old('nama_kategori_produk') : $kategori_produk->nama_kategori_produk }}" disabled>
                    </div>
  
                  <div class="card-footer">
                    {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                    <a href="{{ route('kategoriProduk') }}" class="btn btn-primary btn-md">Kembali</a>
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
