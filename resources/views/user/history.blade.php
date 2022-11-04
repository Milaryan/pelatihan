@extends('user.part.main')

@section('content')

<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Riwayat<span>Checkout</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('userDashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Riwayat Checkout</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            <table class="table table-wishlist table-mobile">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Total Harga</th>
                        <th>Status Checkout</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @if(count($transaksi) > 0)
                        @foreach($transaksi as $t)
                            <tr>
                                <td class="product-col">
                                    <div class="product">
                                        <figure class="product-media">
                                            <a href="{{ route('userProduk', $t->transaksi_detail[0]->produk->slug_produk) }}">
                                                <img src="{{ asset('img/produk/'.$t->transaksi_detail[0]->produk->foto_produk) }}" alt="Product image">
                                            </a>
                                        </figure>

                                        <h3 class="product-title">
                                            <a href="{{ route('userProduk', $t->transaksi_detail[0]->produk->slug_produk) }}">{{ $t->transaksi_detail[0]->produk->nama_produk }}</a>
                                        </h3><!-- End .product-title -->
                                    </div><!-- End .product -->
                                </td>
                                <td class="price-col">{{ $t->transaksi_detail[0]->produk->harga_produk*$t->transaksi_detail[0]->qty }}</td>
                                <td class="stock-col"><span class="in-stock">{{ $t->status_transaksi }}</span></td>
                                <td class="action-col">
                                    @if ($t->status_transaksi == 'Pengiriman')
                                    <form action="{{ route('userCheckoutComplete') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $t->id_transaksi }}">
                                        <button class="btn btn-block btn-outline-success" type="submit">
                                            <i class="icon-check"></i>Ubah Menjadi Selesai
                                        </button>
                                    </form>
                                    @else
                                        Tidak Ada Aksi
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                            <tr>
                                <td colspan="4">Tidak Ada Data</td>
                            </tr>
                    @endif
                </tbody>
            </table><!-- End .table table-wishlist -->
            <div class="wishlist-share">
                <div class="social-icons social-icons-sm mb-2">
                    <label class="social-label">Share on:</label>
                    <a href="#" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                    <a href="#" class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                    <a href="#" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                    <a href="#" class="social-icon" title="Youtube" target="_blank"><i class="icon-youtube"></i></a>
                    <a href="#" class="social-icon" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                </div><!-- End .soial-icons -->
            </div><!-- End .wishlist-share -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
</main><!-- End .main -->

@endsection