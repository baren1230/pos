<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">{{ $breadcrumbTitle ?? 'Laporan' }}</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Laporan</li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumbActive ?? 'Laporan' }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
