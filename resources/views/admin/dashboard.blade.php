@extends('layouts.app')
@section('sj')
    <script src="{{ $chart->cdn() }}"></script>
    <script src="{{ $chartminggu->cdn() }}"></script>

    {{ $chart->script() }}
    {{ $chartminggu->script() }}
@endsection
@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            @include('admin.partials.breadcrumb', [
                'breadcrumbActive' => 'Dashboard',
            ])
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- [ sample-page ] start -->
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-muted">Laba / Rugi</h6>
                            <h4 class="mb-3">Rp {{ number_format($profitOrLoss, 0, ',', '.') }}
                                <span class="badge bg-light-primary border border-primary"></span>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-muted">Total Pembelian</h6>
                            <h4 class="mb-3">Rp {{ number_format($totalSum, 0, ',', '.') }}
                                <span class="badge bg-light-success border border-success"></span>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-muted">Total Penjualan</h6>
                            <h4 class="mb-3">Rp {{ number_format($totalSales, 0, ',', '.') }}
                                <span class="badge bg-light-warning border border-warning"></span>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-muted">Total Pengeluaran</h6>
                            <h4 class="mb-3">Rp {{ number_format($totalExpenses, 0, ',', '.') }}
                                <span class="badge bg-light-danger border border-danger"></span>
                            </h4>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 f-w-400 text-muted">Total Keseluruhan</h6>
                            {!! $chart->container() !!}
                        </div>
                    </div>
                </div> --}}

                {{-- <div>{!! $chart->container() !!}</div> --}}

                <div class="col-md-12 col-xl-8">

                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content" id="chart-tab-tabContent">
                                <div>{!! $chart->container() !!}</div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <div>{!! $chartminggu->container() !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
