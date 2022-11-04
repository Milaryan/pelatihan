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
                <form method="post" action="{{ route('ProdukStore') }}" enctype="multipart/form-data">
                    @csrf
                  <div class="card-body">
                    <div class="form-group">
                      <label for="nama_produk">Nama Produk</label>
                      <input type="text" name="nama_produk" class="form-control" id="nama_produk" placeholder="Masukkan nama produk" value="{{old('nama_produk')}}">
                    </div>
                    <div class="form-group">
                        <label for="kategori_produk">Kategori Produk</label>
                        <select name="kategori_produk" id="kategori_produk" class="form-control">
                        <option value="">.:: Pilih Kategori ::.</option>
                            @foreach($kategori_produk as $key => $prov)
                            <option value="{{ $prov->id_kategori_produk }}">{{ $prov->nama_kategori_produk }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="stok">Stok Produk</label>
                      <input type="text" name="stok" class="form-control" id="stok" placeholder="Masukkan stok" value="{{old('stok')}}">
                    </div>
                    <div class="form-group">
                      <label for="berat">Berat Produk (gram)</label>
                      <input type="text" name="berat" class="form-control" id="berat" placeholder="Masukkan berat" value="{{old('berat')}}">
                    </div>
                    <div class="form-group">
                      <label for="harga">Harga Produk</label>
                      <input type="text" name="harga" class="form-control" id="harga" placeholder="Masukkan harga" value="{{old('harga')}}">
                    </div>
                    <div class="form-group">
                      <label for="deskripsi">Deskripsi Produk</label>
                      <textarea name="deskripsi" id="deskripsi" class="form-control" cols="30" rows="3" placeholder="Masukkan deskripsi produk" value="{{old('deskripsi')}}"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="foto">Foto Produk</label>
                      <input type="file" name="foto" class="form-control" id="foto" placeholder="Masukkan foto" value="{{old('foto')}}">
                    </div>
                  
                  <div class="card-footer">
                    <a href="{{ route('Produk') }}" class="btn btn-secondary btn-md">Kembali</a>
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

@section('script')

<script>
    function getKabupaten(){
        let id_provinsi = $('#provinsi').val();
        if (id_provinsi) {
            $.post("{{ route('usersGetKabupaten') }}", {id_provinsi:id_provinsi}).done((data) => {
                if(data.status == 'success'){
                    let html = '<option value="">.:: Pilih Kabupaten ::.</option>';
                    data.data.forEach((v,i) => {
                        html += `<option value="${v.id_kabupaten}">${v.nama_kabupaten}</option>`
                    });

                    $('#kabupaten').html(html)
                }else{
                    toastr.error(`${data.message}`);
                }
            });
        }else{
            toastr.error('Provinsi Tidak Boleh Kosong');
        }
    }
</script>
    
@endsection