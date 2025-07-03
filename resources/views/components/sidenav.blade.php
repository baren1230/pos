<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <img src="{{ asset('assets/images/logo_toko1.png') }}" alt="Logo Toko"
                style="max-width: 250px; height: auto; margin-top: 10px; margin-left: -70px;">
        </div>
        {{-- <div class="m-header">
            @php
                $logoImageUrl = \App\Models\Setting::getImage('logo_image');
            @endphp
            <img src="{{ $logoImageUrl ? asset('storage/' . $logoImageUrl) : asset('assets/images/logo_toko1.png') }}"
                alt="Logo Toko" style="max-width: 170px; height: auto; margin-top: 10px; margin-left: -1px;">
        </div> --}}
        <div class="navbar-content">
            <ul class="pc-navbar">

                @if (Auth::user()->role == 'admin')
                    <li class="pc-item">
                        <a href="{{ url('/dashboard') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('produk.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-package"></i></span>
                            <span class="pc-mtext">Manajemen Produk</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('admin.supplier.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-users"></i></span>
                            <span class="pc-mtext">Supplier</span>
                        </a>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-menu"></i></span>
                            <span class="pc-mtext">Laporan</span>
                            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="{{ route('laporan.pembelian') }}">Pembelian</a>
                            </li>
                            <li class="pc-item"><a class="pc-link" href="{{ route('laporan.stok_produk') }}">Stok
                                    Produk</a></li>
                            <li class="pc-item"><a class="pc-link" href="{{ route('laporan.penjualan') }}">Penjualan</a>
                            </li>
                            <li class="pc-item"><a
                                    class="pc-link"href="{{ route('laporan.pengeluaran') }}">Pengeluaran</a></li>
                            <li class="pc-item"><a class="pc-link" href="{{ route('laporan.laba_rugi') }}">Data Laba
                                    Rugi</a></li>
                        </ul>
                    </li>
                    <li class="pc-item pc-caption">
                        <label>Other</label>
                        <i class="ti ti-brand-chrome"></i>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('setting.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-settings"></i></span>
                            <span class="pc-mtext">Setting</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('users.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-users"></i></span>
                            <span class="pc-mtext">Kelola Pengguna</span>
                        </a>
                    </li>
                @elseif (Auth::user()->role == 'kasir')
                    <li class="pc-item">
                        <a href="{{ url('/dashboard') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('kasir.transactionHistory') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-brand-chrome"></i></span>
                            <span class="pc-mtext">Riwayat Transaksi</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
