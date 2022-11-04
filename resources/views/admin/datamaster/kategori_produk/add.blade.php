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
                <form method="post" action="{{ route('kategoriProdukStore') }}">
                    @csrf
                  <div class="card-body">
                    <div class="form-group">
                      <label for="nama_kategori_produk">Nama Kategori Produk</label>
                      <input type="text" name="nama_kategori_produk" class="form-control" id="nama_kategori_produk" placeholder="Masukkan nama Kategori Produk" value="{{old('nama_kategori_produk')}}">
                    </div>
  
                  <div class="card-footer">
                    <a href="{{ route('kategoriProduk') }}" class="btn btn-secondary">Kembali</a>
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