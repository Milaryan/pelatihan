<header class="header">
    <div class="header-top">
        <div class="container">
            <div class="header-left">
                <div class="header-dropdown">
                    <ul class="top-menu">
                        <li>
                            <a href="#">Links</a>
                            <ul>
                                <li><a href="tel:#"><i class="icon-whatsapp"></i> +62 896 9159 5159</a></li>
                            </ul>
                        </li>
                    </ul><!-- End .top-menu -->
                </div><!-- End .header-dropdown -->
            </div><!-- End .header-left -->

            <div class="header-right">
                <div class="header-dropdown">
                    <ul class="top-menu">
                        <li>
                            <a href="#">Links</a>
                            <ul>
                                @if (Auth::check())
                                <li><a href="{{ route('userHistory') }}"><i class="icon-home"></i>Riwayat Checkout</a></li>
                                <li><a href="#" data-toggle="modal"><i class="icon-user"></i>{{ Auth::user()->nama_lengkap }}</a></li>
                                <li><a href="{{ route('logout') }}" onclick="return confirm('Apakah Anda ingin Logout?')">
                                    <i class="nav-icon fas fa-sign-out-alt"></i>
                                      Logout
                                  </a></li>
                                @else
                                <li><a href="{{ route('login') }}" class="btn">
                                    <i class="nav-icon fas fa-sign-out-alt"></i>
                                      LogIn
                                  </a></li>
                                @endif
                            </ul>
                        </li>
                    </ul><!-- End .top-menu -->
                </div><!-- End .header-dropdown -->
            </div><!-- End .header-right -->
        </div><!-- End .container -->
    </div><!-- End .header-top -->

    <div class="header-middle sticky-header">
        <div class="container">
            <div class="header-left">
                <button class="mobile-menu-toggler">
                    <span class="sr-only">Toggle mobile menu</span>
                    <i class="icon-bars"></i>
                </button>

                <a href="{{route('userDashboard')}}" class="logo">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Molla Logo" width="105" height="25">
                </a>
                
                <nav class="main-nav">
                    <ul class="menu sf-arrows">
                        <li>
                            <a href="product.html" class="sf-with-ul">Kategori</a>

                            <div class="megamenu megamenu-sm">
                                <div class="row no-gutters">
                                    <div class="col-md-6">
                                        <div class="menu-col">
                                            <div class="menu-title">Kategori Produk</div><!-- End .menu-title -->
                                            <ul>
                                            @foreach($kategori_produk as $k)
                                                <li><a class="nav-link" id="top-{{ $k->id_kategori_produk }}-link" data-toggle="tab" href="#top-{{ $k->id_kategori_produk }}-tab" role="tab" aria-controls="top-{{ $k->id_kategori_produk }}-tab" aria-selected="false">{{ $k->nama_kategori_produk }}</a></li>
                                            @endforeach
                                            </ul>
                                        </div><!-- End .menu-col -->
                                    </div><!-- End .col-md-6 -->
                                </div><!-- End .row -->
                            </div><!-- End .megamenu megamenu-sm -->
                        </li>
                    </ul><!-- End .menu -->
                </nav><!-- End .main-nav -->
            </div><!-- End .header-left -->

            <div class="header-right">
                <div class="dropdown cart-dropdown">
                    @if(Auth::check())
                        @php
                            $get_keranjang = DB::table('keranjang as k')
                                                ->where('user_id', Auth::id())
                                                ->join('produk as p', 'p.id_produk', 'k.produk_id')
                                                ->get();
                        @endphp
                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                        <i class="icon-shopping-cart"></i>
                        <span class="cart-count">{{ count($get_keranjang) }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-cart-products">
                            @if(count($get_keranjang) > 0)
                                @foreach($get_keranjang as $gk)
                                    <div class="product">
                                        <div class="product-cart-details">
                                            <h4 class="product-title">
                                                <a href="{{ route('userProduk', $gk->slug_produk) }}">{{ $gk->nama_produk }}</a>
                                            </h4>

                                            <span class="cart-product-info">
                                                <span class="cart-product-qty">{{ $gk->qty }}</span>
                                                - Total : {{ $gk->qty*$gk->harga_produk }}
                                            </span>
                                            <form action="{{ route('userCheckout') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $gk->id_keranjang }}">
                                                <button type="submit" class="btn btn-outline-primary-2 mt-3"><span>Beli</span><i class="icon-long-arrow-right"></i></button>
                                            </form>
                                        </div><!-- End .product-cart-details -->

                                        <figure class="product-image-container">
                                            <a href="{{ route('userProduk', $gk->slug_produk) }}" class="product-image">
                                                <img src="{{ asset('img/produk/'.$gk->foto_produk) }}" alt="product">
                                            </a>
                                        </figure>
                                        <form action="{{ route('userRemoveToChart') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $gk->produk_id }}">
                                            <button type="submit" href="" class="btn-remove" title="Remove Product"><i class="icon-close" onclick="return confirm('Yakin ?')"></i></button>
                                        </form>
                                    </div><!-- End .product -->
                                @endforeach
                            @else
                                <div>Tidak Ada Produk</div>
                            @endif
                        </div><!-- End .cart-product -->
                        
                        <div class="dropdown-cart-action">
                        </div><!-- End .dropdown-cart-total -->
                    </div><!-- End .dropdown-menu -->
                    @endif
                </div><!-- End .cart-dropdown -->
            </div><!-- End .header-right -->
        </div><!-- End .container -->
    </div><!-- End .header-middle -->
</header><!-- End .header -->