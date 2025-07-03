@extends('layouts.app')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ Breadcrumb ] -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Tambah Pembelian Produk</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('laporan.pembelian') }}">Laporan Pembelian</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Tambah Pembelian</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- [ Main Content ] -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Form Tambah Pembelian</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('pembelian.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="tanggal" class="form-label">Tanggal Pembelian</label>
                                    <input type="date" id="tanggal" name="tanggal" class="form-control"
                                        value="{{ old('tanggal') }}" required>
                                    @error('tanggal')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="suplayer_id" class="form-label">Suplayer</label>
                                    <select id="suplayer_id" name="suplayer_id" class="form-control" required>
                                        <option value="">Pilih Suplayer</option>
                                        @foreach ($suplayers as $suplayer)
                                            <option value="{{ $suplayer->id }}"
                                                {{ old('suplayer_id') == $suplayer->id ? 'selected' : '' }}>
                                                {{ $suplayer->nama_suplayer }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('suplayer_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div id="produk-list">
                                    <div class="produk-item mb-3 row">
                                        <div class="col-md-6">
                                            <label for="produk_id[]" class="form-label">Produk</label>
                                            <select name="produk_id[]" class="form-control" required>
                                                <option value="">Pilih Produk</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}"
                                                        {{ old('produk_id.0') == $product->id ? 'selected' : '' }}>
                                                        {{ $product->nama_produk }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="quantity[]" class="form-label">Jumlah</label>
                                            <input type="number" name="quantity[]" class="form-control" min="1"
                                                value="{{ old('quantity.0', 1) }}" required>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-remove-produk">Hapus</button>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-secondary mb-3" id="btn-add-produk">Tambah
                                    Produk</button>

                                <div>
                                    <button type="submit" class="btn btn-primary">Simpan Pembelian</button>
                                    <a href="{{ route('laporan.pembelian') }}" class="btn btn-secondary">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnAddProduk = document.getElementById('btn-add-produk');
            const produkList = document.getElementById('produk-list');

            btnAddProduk.addEventListener('click', function() {
                const produkItems = produkList.getElementsByClassName('produk-item');
                const lastItem = produkItems[produkItems.length - 1];
                const newItem = lastItem.cloneNode(true);

                // Reset values in cloned item
                const selects = newItem.getElementsByTagName('select');
                for (let select of selects) {
                    select.selectedIndex = 0;
                }
                const inputs = newItem.getElementsByTagName('input');
                for (let input of inputs) {
                    if (input.type === 'number') {
                        input.value = 1;
                    }
                }

                produkList.appendChild(newItem);

                // Add event listener to remove button
                const removeButtons = produkList.getElementsByClassName('btn-remove-produk');
                for (let btn of removeButtons) {
                    btn.onclick = function() {
                        if (produkList.children.length > 1) {
                            this.closest('.produk-item').remove();
                        }
                    };
                }
            });

            // Initial remove button event listeners
            const removeButtons = produkList.getElementsByClassName('btn-remove-produk');
            for (let btn of removeButtons) {
                btn.onclick = function() {
                    if (produkList.children.length > 1) {
                        this.closest('.produk-item').remove();
                    }
                };
            }
        });
    </script>
@endsection
