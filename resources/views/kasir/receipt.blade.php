@extends('layouts.app')

@section('content')
    <style>
        @page {
            size: 80mm auto;
            /* Set width to 80mm, height auto */
            margin: 5mm;
            /* smaller margin for receipt */
        }

        @media print {
            body * {
                visibility: hidden;
            }

            .table-responsive,
            .table-responsive * {
                visibility: visible;
            }

            .table-responsive {
                position: absolute;
                left: 0;
                top: 0;
                width: 80mm;
                /* match the page width */
            }
        }
    </style>
    <script>
        function printReceipt() {
            var printContents = document.querySelector('.table-responsive').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>
    <div class="pc-container">
        <div class="pc-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Resi Transaksi</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Resi</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow p-4 mb-4">
                <div class="card-body">
                    <div class="mb-4">
                        <h5 class="mb-2">Transaksi #{{ $transaction->id }}</h5>
                        <p class="text-muted mb-1"><strong>Kasir:</strong>
                            {{ $transaction->user ? $transaction->user->name : 'Guest' }}</p>
                        <p class="text-muted mb-1"><strong>Tanggal:</strong>
                            {{ $transaction->created_at->format('d-m-Y H:i') }}</p>
                        <p class="text-muted"><strong>Metode Pembayaran:</strong>
                            {{ ucfirst($transaction->payment_method) }}</p>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaction->items as $item)
                                    <tr>
                                        <td>{{ $item->produk->nama_produk }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total</strong></td>
                                    <td><strong>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex gap-2">
                        <button onclick="printReceipt()" class="btn btn-primary">
                            Cetak Resi
                        </button>
                        <a href="{{ route('kasir.index') }}" class="btn btn-secondary">
                            Kembali ke Kasir
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
