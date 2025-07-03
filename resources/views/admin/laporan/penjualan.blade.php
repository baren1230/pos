@extends('layouts.app')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ Breadcrumb ] -->
            @include('admin.laporan.partials.breadcrumb', [
                'breadcrumbTitle' => 'Penjualan',
                'breadcrumbActive' => 'Penjualan',
            ])

            <!-- [ Main Content ] -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card p-4 mb-4">
                        <div class="card-body">
                            <h1>Data Penjualan</h1>
                            <table class="table table-hover table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Jumlah Terjual</th>
                                        <th>Harga Satuan</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalSum = 0;
                                    @endphp
                                    @forelse ($groupedItems as $item)
                                        @php
                                            $totalSum += $item['total'];
                                        @endphp
                                        <tr>
                                            <td>{{ $item['nama_produk'] }}</td>
                                            <td>{{ $item['jumlah_terjual'] }}</td>
                                            <td>Rp {{ number_format($item['harga_satuan'], 2) }}</td>
                                            <td>Rp {{ number_format($item['total'], 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada data penjualan.</td>
                                        </tr>
                                    @endforelse
                                    @if (count($groupedItems) > 0)
                                        <tr>
                                            <td colspan="3" class="text-end fw-bold">Total</td>
                                            <td class="fw-bold">Rp {{ number_format($totalSum, 2) }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card p-4 mb-4">
                        <div class="card-body">
                            <h1>Riwayat Transaksi</h1>

                            @if ($transactions->isEmpty())
                                <p>Tidak ada riwayat transaksi.</p>
                            @else
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID Transaksi</th>
                                            <th>Tanggal</th>
                                            <th>Total</th>
                                            <th>Items</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transactions as $transaction)
                                            <tr>
                                                <td>{{ $transaction->id }}</td>
                                                <td>{{ $transaction->created_at->format('d-m-Y H:i') }}</td>
                                                <td>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                                                <td>
                                                    <ul>
                                                        @foreach ($transaction->items as $item)
                                                            <li>{{ $item->produk->nama_produk }} x
                                                                {{ $item->quantity }} (Rp
                                                                {{ number_format($item->subtotal, 0, ',', '.') }})</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
