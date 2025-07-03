@extends('layouts.app')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ Breadcrumb ] -->
            @include('admin.laporan.partials.breadcrumb', [
                'breadcrumbTitle' => 'Pembelian',
                'breadcrumbActive' => 'Pembelian',
            ])

            <!-- [ Main Content ] -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card p-4 mb-4">
                        {{-- <div class="card-header d-flex justify-content-between align-items-center">
                            <h5>Riwayat Barang Masuk (Produk)</h5>
                        </div> --}}
                        <div class="card-body">
                            <form method="GET" action="{{ route('laporan.pembelian') }}" class="mb-4">
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-3">
                                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                                        <input type="date" id="start_date" name="start_date" class="form-control"
                                            value="{{ request('start_date') }}">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="end_date" class="form-label">Tanggal Akhir</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control"
                                            value="{{ request('end_date') }}">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="supplier_id" class="form-label">Supplier</label>
                                        <select id="supplier_id" name="supplier_id" class="form-select">
                                            <option value="">Semua Supplier</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}"
                                                    {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                                    {{ $supplier->nama_supplier }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3 d-flex flex-wrap gap-2 justify-content-end">
                                        <div>
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="{{ route('laporan.pembelian') }}"
                                                class="btn btn-outline-secondary">Reset</a>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive mt-3">
                                <table class="table table-hover table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nama Produk</th>
                                            <th>Stok (Dari Pembelian)</th>
                                            <th>Suplayer</th>
                                            <th>Ukuran</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Harga Beli</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalSum = 0;
                                        @endphp
                                        @forelse ($products as $product)
                                            @php
                                                $purchaseStock = $purchaseStocks[$product->id] ?? 0;
                                                $lineTotal =
                                                    $product->harga_beli && $purchaseStock
                                                        ? $product->harga_beli * $purchaseStock
                                                        : 0;
                                                $totalSum += $lineTotal;
                                            @endphp
                                            <tr>
                                                <td>{{ $product->nama_produk ?? '-' }}</td>
                                                <td>{{ $purchaseStocks[$product->id] ?? '-' }}</td>
                                                <td>{{ $product->supplier->nama_supplier ?? '-' }}</td>
                                                <td>{{ $product->ukuran ?? '-' }}</td>
                                                <td>{{ $product->created_at ? $product->created_at->format('d-m-Y') : '-' }}
                                                </td>
                                                <td>{{ $product->harga_beli ? number_format($product->harga_beli, 0, ',', '.') : '-' }}
                                                </td>
                                                <td>{{ $lineTotal ? number_format($lineTotal, 0, ',', '.') : '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">Tidak ada data produk.</td>
                                            </tr>
                                        @endforelse
                                        @if ($products->count() > 0)
                                            <tr>
                                                <td colspan="6" class="text-end fw-bold">Total</td>
                                                <td class="fw-bold">{{ number_format($totalSum, 0, ',', '.') }}</td>
                                            </tr>
                                        @endif
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
