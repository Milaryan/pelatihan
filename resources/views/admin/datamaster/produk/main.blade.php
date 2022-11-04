@extends('admin.part.main')

@section('container')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{ $judul }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">{{ $judul }}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Tabel {{ $judul }}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <a href="{{ route('ProdukCreate') }}" class="btn btn-primary btn-sm mb-2">Tambah {{ $judul }}</a>
              <table id="tabel-data" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Produk</th>
                  <th>Kategori Produk</th>
                  <th>Slug Produk</th>
                  <th>Stok Produk</th>
                  <th>Berat Produk</th>
                  <th>Harga Produk</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach($produk as $key => $us)
                <tr>
                  <td>{{ $key+1 }}</td>
                  <td>{{ $us->nama_produk }}</td>
                  <td>{{ $us->kategori_produk->nama_kategori_produk }}</td>
                  <td>{{ $us->slug_produk }}</td>
                  <td>{{ $us->stok_produk }}</td>
                  <td>{{ $us->berat_produk }}</td>
                  <td>{{ $us->harga_produk }}</td>
                  <td>
                      <a href="{{ route('ProdukShow', $us->id_produk) }}" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a>
                      <a href="{{ route('ProdukEdit', $us->id_produk) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                      <a href="{{ route('ProdukDelete', $us->id_produk) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash" onclick="return confirm('Apakah anda ingin menghapus Data?')"></i></a>
                  </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Kategori Produk</th>
                    <th>Slug Produk</th>
                    <th>Stok Produk</th>
                    <th>Berat Produk</th>
                    <th>Harga Produk</th>
                    <th>Aksi</th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>


@endsection

@section('script')

<script>
    $("#tabel-data").DataTable();
</script>

@endsection