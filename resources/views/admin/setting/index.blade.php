@extends('layouts.app')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            @include('admin.users.partials.breadcrumb', [
                'breadcrumbActive' => 'Setting',
            ])
            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        {{-- <div class="card-header">
                            <h5>Payment Method Settings</h5>
                        </div> --}}
                        <div class="card-body">
                            <form action="{{ route('admin.settings.updateQrisImage') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="qris_image" class="form-label">QRIS Payment Method Image</label>
                                    <input class="form-control" type="file" id="qris_image" name="qris_image"
                                        accept="image/*">
                                </div>
                                @if (isset($qrisImageUrl) && $qrisImageUrl)
                                    <div class="mb-3">
                                        <label class="form-label">Current QRIS Image:</label>
                                        <div>
                                            <img src="{{ asset('storage/' . $qrisImageUrl) }}" alt="QRIS Image"
                                                style="max-height: 150px;">
                                        </div>
                                    </div>
                                @endif
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="enable_qris" name="enable_qris"
                                        {{ isset($enableQris) && $enableQris ? 'checked' : '' }}>
                                    <label class="form-check-label" for="enable_qris">Enable QRIS Payment Method</label>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Settings</button>
                            </form>

                            <hr>

                            {{-- <form action="{{ route('admin.settings.updateLogoImage') }}" method="POST"
                                enctype="multipart/form-data" class="mt-4">
                                @csrf
                                <div class="mb-3">
                                    <label for="logo_image" class="form-label">Store Logo Image</label>
                                    <input class="form-control" type="file" id="logo_image" name="logo_image"
                                        accept="image/*">
                                </div>
                                @php
                                    $logoImageUrl = \App\Models\Setting::getImage('logo_image');
                                @endphp
                                @if ($logoImageUrl)
                                    <div class="mb-3">
                                        <label class="form-label">Current Logo Image:</label>
                                        <div>
                                            <img src="{{ asset('storage/' . $logoImageUrl) }}" alt="Logo Image"
                                                style="max-height: 150px;">
                                        </div>
                                    </div>
                                @endif
                                <button type="submit" class="btn btn-primary">Save Logo</button>
                            </form> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
