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
              <form action="{{ route('laporanPenjualan') }}" method="GET">
                <div class="row mb-2">
                  <div class="col">
                    Range Tanggal
                  </div>
                  <div class="col-4">
                    <input type="date" class="form-control" name="tanggal_awal" id="tanggal_awal" value="{{ isset($_GET['tanggal_awal']) ?$_GET['tanggal_awal'] : date('Y-m-d') }}">
                  </div>
                  <div class="col-0">
                    -
                  </div>
                  <div class="col-4">
                    <input type="date" class="form-control" name="tanggal_akhir" id="tanggal_akhir" value="{{ isset($_GET['tanggal_akhir']) ?$_GET['tanggal_akhir'] : date('Y-m-d') }}">
                  </div>
                  <div class="col">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>Cari</button>
                    <a class="btn btn-warning" onclick="print()"><i class="fa fa-print"></i>Print</a>
                  </div>
                </div>
              </form>
              <table id="tabel-data" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Kode Transaksi</th>
                  <th>Kode Invoice</th>
                  <th>Nama Pembeli</th>
                  <th>Produk</th>
                  <th>QTY</th>
                  <th>Tanggal Transaksi</th>
                  <th>Status Transaksi</th>
                  <th>Alamat Tujuan</th>
                  <th>Ekspedisi</th>
                  <th>Catatan Pembeli</th>
                </tr>
                </thead>
                <tbody>
                @foreach($laporan_penjualan as $key => $us)
                <tr>
                  <td>{{ $key+1 }}</td>
                  <td>{{ $us->kode_transaksi }}</td>
                  <td>{{ $us->kode_invoice }}</td>
                  <td>{{ $us->users->nama_lengkap }}</td>
                  <td>
                    <ol>
                      @foreach($us->transaksi_detail as $td)
                        <li>{{ $td->produk->nama_produk }}</li>
                      @endforeach
                    </ol>
                  </td>
                  <td>
                    <ul>
                      @foreach($us->transaksi_detail as $td)
                        <li>{{ $td->qty }}</li>
                      @endforeach
                    </ul>
                  </td>
                  <td>{{ $us->tanggal_transaksi }}</td>
                  <td>{{ $us->status_transaksi }}</td>
                  <td>PROVINSI {{ ($us->provinsi->nama_provinsi) ? $us->provinsi->nama_provinsi : '-' }}, {{ ($us->kabupaten->nama_kabupaten) ? $us->kabupaten->nama_kabupaten : '-' }}, KODE POS {{ ($us->kode_pos) ? $us->kode_pos : '-' }}, {{ ($us->alamat_lengkap) ? $us->alamat_lengkap : '-' }}</td>
                  <td>{{ $us->ekspedisi }}</td>
                  <td>{{ $us->catatan_pembeli }}</td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Kode Transaksi</th>
                    <th>Kode Invoice</th>
                    <th>Nama Pembeli</th>
                    <th>Produk</th>
                    <th>QTY</th>
                    <th>Tanggal Transaksi</th>
                    <th>Status Transaksi</th>
                    <th>Alamat Tujuan</th>
                    <th>Ekspedisi</th>
                    <th>Catatan Pembeli</th>
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

    window.print()
    window.onfocus=function(){window.close()}
</script>

@endsection