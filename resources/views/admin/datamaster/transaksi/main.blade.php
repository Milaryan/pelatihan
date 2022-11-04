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
              <a href="{{ route('TransaksiCreate') }}" class="btn btn-primary btn-sm mb-2">Tambah {{ $judul }}</a>
              <table id="tabel-data" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Kode Transaksi</th>
                  <th>Kode Invoice</th>
                  <th>Nama Pembeli</th>
                  <th>Tanggal Transaksi</th>
                  <th>Status Transaksi</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach($transaksi as $key => $us)
                <tr>
                  <td>{{ $key+1 }}</td>
                  <td>{{ $us->kode_transaksi }}</td>
                  <td>{{ $us->kode_invoice }}</td>
                  <td>{{ $us->users->nama_lengkap }}</td>
                  <td>{{ $us->tanggal_transaksi }}</td>
                  <td>{{ $us->status_transaksi }}</td>
                  <td>
                      <a href="{{ route('TransaksiShow', $us->id_transaksi) }}" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a>
                      {{-- <a href="{{ route('TransaksiDelete', $us->id_transaksi) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash" onclick="return confirm('Apakah anda ingin menghapus Data?')"></i></a> --}}
                  </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Kode Transaksi</th>
                    <th>Kode Invoice</th>
                    <th>Nama Pembeli</th>
                    <th>Tanggal Transaksi</th></th>
                    <th>Status Transaksi</th>

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