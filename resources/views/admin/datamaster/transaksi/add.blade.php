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
                <h3 class="card-title">Tambah {{ $judul }}</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="{{ route('TransaksiStore') }}">
                  @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="user_id">Pilih Pembeli</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                    <option value="">.:: Pilih Pembeli ::.</option>
                        @foreach($users as $key => $prov)
                        <option value="{{ $prov->id }}">{{ $prov->nama_lengkap }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="produk_id">Pilih Produk</label>
                    <select name="produk_id" id="produk_id" class="form-control" required>
                    <option value="">.:: Pilih Produk ::.</option>
                        @foreach($produk as $key => $prov)
                        <option value="{{ $prov->id_produk }}">{{ $prov->nama_produk }} ({{ $prov->kategori_produk->nama_kategori_produk }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                  <label for="tgl">Tanggal Transaksi</label>
                  <input type="text" name="tgl" class="form-control" id="tgl" value="{{date('Y-m-d')}}" required>
                </div>
                <div class="form-group">
                    <label for="ekspedisi">Pilih Ekspedisi</label>
                    <select name="ekspedisi" id="ekspedisi" class="form-control" required>
                    <option value="">.:: Pilih Ekspedisi ::.</option>
                    <option value="JNE">JNE</option>
                    <option value="JNT">JNT</option>
                    <option value="POS INDONESIA">POS INDONESIA</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Pilih Status</label>
                    <select name="status" id="status" class="form-control" required>
                    <option value="">.:: Pilih Status ::.</option>
                    <option value="Pending">Di Pending</option>
                    <option value="Proses Admin">Di Proses</option>
                    <option value="Pengiriman">Di Kirim</option>
                    <option value="Selesai">Selesai</option>
                    </select>
                </div>
                <div class="form-group">
                  <label for="catatan_pembeli">Catatan Pembeli</label>
                  <textarea name="catatan_pembeli" id="catatan_pembeli" class="form-control" cols="30" rows="3" placeholder="Masukkan Catatan Pembeli" value="{{old('catatan_pembeli')}}" required>{{old('catatan_pembeli')}}</textarea>
                </div>

              <div class="card-footer">
                <a href="{{ route('Transaksi') }}" class="btn btn-secondary btn-md">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
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
