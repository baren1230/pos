@extends('layouts.app')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            @include('kasir.partials.breadcrumb', [
                'breadcrumbActive' => 'Riwayat transaksi',
            ])

            <div class="card shadow p-4 mb-4">
                <div class="card-body">
                    <div class="container">
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
                                                        <li>{{ $item->produk->nama_produk }} x {{ $item->quantity }} (Rp
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

    {{-- <div class="container">
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
                                        <li>{{ $item->produk->nama_produk }} x {{ $item->quantity }} (Rp
                                            {{ number_format($item->subtotal, 0, ',', '.') }})</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div> --}}
@endsection
