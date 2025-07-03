@extends('layouts.app')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ Breadcrumb ] -->
            @include('admin.laporan.partials.breadcrumb', [
                'breadcrumbTitle' => 'Stok Produk',
                'breadcrumbActive' => 'Stok Produk',
            ])

            <!-- [ Main Content ] -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="GET" action="{{ route('laporan.stok_produk') }}" class="mb-3">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="kategori_id" class="form-label">Kategori</label>
                                        <select id="kategori_id" name="kategori_id" class="form-control">
                                            <option value="">Semua Kategori</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ request('kategori_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="ukuran" class="form-label">Ukuran</label>
                                        <select id="ukuran" name="ukuran" class="form-control">
                                            <option value="">Semua Ukuran</option>
                                            @foreach ($ukuranList as $ukuran)
                                                <option value="{{ $ukuran }}"
                                                    {{ request('ukuran') == $ukuran ? 'selected' : '' }}>
                                                    {{ $ukuran }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="warna" class="form-label">Warna</label>
                                        <select id="warna" name="warna" class="form-control">
                                            <option value="">Semua Warna</option>
                                            @foreach ($warnaList as $warna)
                                                <option value="{{ $warna }}"
                                                    {{ request('warna') == $warna ? 'selected' : '' }}>
                                                    {{ $warna }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 align-self-end">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="{{ route('laporan.stok_produk') }}" class="btn btn-secondary">Reset</a>
                                    </div>
                                </div>
                            </form>

                            <div class="mb-4">
                                <table class="table table-hover table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama Produk</th>
                                            <th>Kategori</th>
                                            <th>Ukuran</th>
                                            <th>Warna</th>
                                            <th>Sisa Stok</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($products as $product)
                                            <tr>
                                                <td>{{ $product->id }}</td>
                                                <td>{{ $product->nama_produk }}</td>
                                                <td>{{ $product->category->name ?? '-' }}</td>
                                                <td>{{ $product->ukuran ?? '-' }}</td>
                                                <td>{{ $product->warna ?? '-' }}</td>
                                                <td>{{ $product->stok }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Tidak ada data produk.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
