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
                <form method="post" action="{{ route('usersStore') }}">
                    @csrf
                  <div class="card-body">
                    <div class="form-group">
                      <label for="nama_lengkap">Nama Lengkap</label>
                      <input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap" placeholder="Masukkan nama lengkap" value="{{old('nama_lengkap')}}">
                    </div>
                    <div class="form-group">
                      <label for="username">Username</label>
                      <input type="text" name="username" class="form-control" id="username" placeholder="Masukkan username" value="{{old('username')}}">
                    </div>
                    <div class="form-group">
                      <label for="email">Alamat Email</label>
                      <input type="email" name="email" class="form-control" id="email" placeholder="Masukkan Email" value="{{old('email')}}">
                    </div>
                    <div class="form-group">
                      <label for="password">Password</label>
                      <input type="password" name="password"class="form-control" id="password" placeholder="Masukkan Password" value="{{old('password')}}">
                    </div>
                    <div class="form-group">
                        <label for="no_telp">No Telp</label>
                        <input type="text" name="no_telp" class="form-control" id="no_telp" placeholder="Masukkan no telp" value="{{old('no_telp')}}">
                    </div>
                    <div class="form-group">
                        <label for="provinsi">Provinsi</label>
                        <select name="provinsi" id="provinsi" class="form-control" onchange="getKabupaten()">
                        <option value="">.:: Pilih Provinsi ::.</option>
                            @foreach($provinsi as $key => $prov)
                            <option value="{{ $prov->id_provinsi }}">{{ $prov->nama_provinsi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kabupaten">Kabupaten</label>
                        <select name="kabupaten" id="kabupaten" class="form-control">
                        <option value="">.:: Pilih Kabupaten ::.</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kode_pos">Kode Pos</label>
                        <input type="text" name="kode_pos" class="form-control" id="kode_pos" placeholder="Masukkan Kode Pos" value="{{old('kode_pos')}}">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat Lengkap</label>
                        <textarea name="alamat" id="alamat" class="form-control" cols="30" rows="3" placeholder="Masukkan alamat lengkap" value="{{old('alamat')}}"></textarea>
                    </div>
  
                  <div class="card-footer">
                    <a href="{{ route('users') }}" class="btn btn-secondary btn-md">Kembali</a>
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