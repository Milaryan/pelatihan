@extends('user.part.main')

@section('content')

<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
    <div class="container">
        <h1 class="page-title">Checkout</h1>
    </div><!-- End .container -->
</div><!-- End .page-header -->
<nav aria-label="breadcrumb" class="breadcrumb-nav">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('userDashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
        </ol>
    </div><!-- End .container -->
</nav><!-- End .breadcrumb-nav -->

<div class="page-content">
    <div class="checkout">
        <div class="container">
            <form action="{{ route('userCheckoutProses') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-9">
                        <h2 class="checkout-title">Detail Checkout</h2><!-- End .checkout-title -->
                        <input type="hidden" name="id_user" value="{{ $user->id }}">
                        <input type="hidden" name="id_keranjang" value="{{ $keranjang->id_keranjang }}">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Nama Lengkap *</label>
                                    <input type="text" class="form-control" readonly value="{{ $user->nama_lengkap }}">
                                </div><!-- End .col-sm-6 -->

                                <div class="col-sm-6">
                                    <label>Username *</label>
                                    <input type="text" class="form-control" readonly value="{{ $user->username }}">
                                </div><!-- End .col-sm-6 -->
                            </div><!-- End .row -->

                            <label>Alamat Lengkap *</label>
                            <textarea class="form-control" name="alamat_lengkap" cols="30" rows="5" placeholder="Nama Jalan, Desa / Perkiraan" required>{{ $user->alamat_lengkap }}</textarea>
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Provinsi *</label>
                                    <input type="text" class="form-control" readonly value="{{ $provinsi->nama_provinsi }}">
                                </div><!-- End .col-sm-6 -->
                                
                                <div class="col-sm-6">
                                    <label>Kabupaten *</label>
                                    <input type="text" class="form-control" readonly value="{{ $kabupaten->nama_kabupaten }}">
                                </div><!-- End .col-sm-6 -->
                            </div><!-- End .row -->
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Kode Pos *</label>
                                    <input type="text" class="form-control" readonly required value="{{ $user->kode_pos }}">
                                </div><!-- End .col-sm-6 -->
                                
                                <div class="col-sm-6">
                                    <label>No HP *</label>
                                    <input type="tel" class="form-control" readonly required value="{{ $user->no_telp }}">
                                </div><!-- End .col-sm-6 -->
                            </div><!-- End .row -->
                            
                            <div class="row">
                                <label for="pengiriman">Pengiriman : </label>
                                <select name="pengiriman" id="pengiriman" class="form-control" required>
                                    <option value="">.:: Pilih Pengiriman ::.</option>
                                    <option value="JNE">JNE</option>
                                    <option value="JNT">JNT</option>
                                    <option value="POS INDONESIA">POS INDONESIA</option>
                                </select>
                            </div>
                            
                            <div class="row">
                            <label>Catatan Pembeli (opsional) *</label>
                            <textarea class="form-control" cols="30" rows="4" placeholder="Catatan Pembeli" name="catatan_pembeli"></textarea>
                            </div>

                    </div><!-- End .col-lg-9 -->
                    <aside class="col-lg-3">
                        <div class="summary">
                            <h3 class="summary-title">Detail Pesanan</h3><!-- End .summary-title -->

                            <table class="table table-summary">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Sub-Total</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td><a href="#">{{ $produk->nama_produk }}</a></td>
                                        <td>Rp. {{ $keranjang->qty*$produk->harga_produk }}</td>
                                    </tr>
                                    <tr class="summary-total">
                                        <td>Total:</td>
                                        <td>Rp. {{ $keranjang->qty*$produk->harga_produk }}</td>
                                    </tr><!-- End .summary-total -->
                                </tbody>
                            </table><!-- End .table table-summary -->

                            <button type="submit" class="btn btn-outline-primary-2 btn-order btn-block">
                                <span class="btn-text">Bayar Sekarang</span>
                                <span class="btn-hover-text">Proses Pesanan</span>
                            </button>
                        </div><!-- End .summary -->
                    </aside><!-- End .col-lg-3 -->
                </div><!-- End .row -->
            </form>
        </div><!-- End .container -->
    </div><!-- End .checkout -->
</div><!-- End .page-content -->

@endsection