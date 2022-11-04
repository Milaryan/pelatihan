<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="{{ csrf_token() }}">
    <title>UP-SKANEDA | {{ $judul }}</title>

    <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
  <link rel="stylesheet" href= "{{ asset('plugins/fontawesome-free/css/all.min.css') }}" >
  {{-- Toastr --}}
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href= "{{ asset('dist/css/adminlte.min.css') }}" >
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
</head>
<body>
  <h1 style="text-align: center" class="mb-5">TABEL LAPORAN PENJUALAN</h1>
  
    <table id="tabel-data" class="table table-bordered table-stripped table-responsive">
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
      </table>
</body>

<script>
    window.print()
    window.onfocus=function(){window.close()}
</script>

</html>