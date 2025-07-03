@extends('layouts.app')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ Breadcrumb ] -->
            @include('admin.laporan.partials.breadcrumb', [
                'breadcrumbTitle' => 'Laba Rugi',
                'breadcrumbActive' => 'Laba Rugi',
            ])

            <!-- [ Main Content ] -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="GET" action="{{ route('laporan.laba_rugi') }}" class="mb-3">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                                        <input type="date" id="start_date" name="start_date" class="form-control"
                                            value="{{ request('start_date', $start) }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="end_date" class="form-label">Tanggal Akhir</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control"
                                            value="{{ request('end_date', $end) }}">
                                    </div>
                                    <div class="col-md-3 align-self-end">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="{{ route('laporan.laba_rugi') }}" class="btn btn-secondary">Reset</a>
                                    </div>
                                </div>
                            </form>

                            <div class="mb-4">
                                <h6>Ringkasan</h6>
                                <table class="table table-bordered w-50">
                                    <tbody>
                                        <tr>
                                            <th>Total Pendapatan</th>
                                            <td>Rp {{ number_format($totalIncome, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Pengeluaran</th>
                                            <td>Rp
                                                {{ number_format(($totalPurchaseCost ?? 0) + ($totalExpenses ?? 0), 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Laba / Rugi</th>
                                            <td>
                                                <span
                                                    @if ($profitOrLoss < 0) class="text-danger" @else class="text-success" @endif>
                                                    Rp {{ number_format($profitOrLoss, 0, ',', '.') }}
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mb-4">
                                <h6>Detail Penjualan</h6>
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th>Nama Produk</th>
                                                <th>Jumlah</th>
                                                <th>Harga Jual</th>
                                                <th>Subtotal</th>
                                                <th>Tanggal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($sales as $sale)
                                                @foreach ($sale->items as $item)
                                                    <tr>
                                                        <td>{{ $item->produk->nama_produk ?? '-' }}</td>
                                                        <td>{{ $item->quantity ?? '-' }}</td>
                                                        <td>Rp {{ number_format($item->price ?? 0, 0, ',', '.') }}
                                                        </td>
                                                        <td>Rp
                                                            {{ number_format($item->subtotal ?? 0, 0, ',', '.') }}
                                                        </td>
                                                        <td>{{ $sale->created_at->format('d-m-Y') }}</td>
                                                    </tr>
                                                @endforeach
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">Tidak ada data penjualan.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div>
                                <h6>Detail Pengeluaran</h6>
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Keterangan</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($expenses as $expense)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($expense->tanggal)->format('d-m-Y') }}
                                                    </td>
                                                    <td>{{ $expense->keterangan }}</td>
                                                    <td>Rp {{ number_format($expense->jumlah, 0, ',', '.') }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center">Tidak ada data pengeluaran.</td>
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
    </div>
@endsection
