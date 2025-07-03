@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Produk</h1>

        <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nama_produk">Nama Produk</label>
                <input type="text" name="nama_produk" id="nama_produk" class="form-control"
                    value="{{ old('nama_produk', $produk->nama_produk) }}" required>
            </div>

            <div class="form-group">
                <label for="kategori_id">Kategori</label>
                <select name="kategori_id" id="kategori_id" class="form-control">
                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $produk->kategori_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name ?? ($category->kategori ?? '') }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="supplier_id">Supplier</label>
                <select name="supplier_id" id="supplier_id" class="form-control">
                    <option value="">Pilih Supplier</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ $produk->supplier_id == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->nama_supplier ?? '' }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
            </div>

            <div class="form-group">
                <label for="harga_beli">Harga Beli</label>
                <input type="number" name="harga_beli" id="harga_beli" class="form-control"
                    value="{{ old('harga_beli', $produk->harga_beli) }}" required>
            </div>

            <div class="form-group">
                <label for="harga">Harga Jual</label>
                <input type="number" name="harga" id="harga" class="form-control"
                    value="{{ old('harga', $produk->harga) }}" required>
            </div>

            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" name="stok" id="stok" class="form-control"
                    value="{{ old('stok', $produk->stok) }}" required>
            </div>

            <div class="form-group">
                <label for="gambar">Gambar Produk</label>
                <input type="file" name="gambar" id="gambar" class="form-control">
                @if ($produk->gambar)
                    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Gambar Produk"
                        style="max-width: 200px; margin-top: 10px;">
                @endif
            </div>

            <button type="submit" class="btn btn-primary mt-2">Update</button>
        </form>
    </div>
@endsection
