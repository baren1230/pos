@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Produk</h1>

        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="nama_produk">Nama Produk</label>
                <input type="text" name="nama_produk" id="nama_produk" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="kategori_id">Kategori</label>
                <select name="kategori_id" id="kategori_id" class="form-control">
                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name ?? ($category->kategori ?? '') }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="supplier_id">Supplier</label>
                <select name="supplier_id" id="supplier_id" class="form-control">
                    <option value="">Pilih Supplier</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier ?? '' }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="harga_beli">Harga Beli</label>
                <input type="number" name="harga_beli" id="harga_beli" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="harga">Harga Jual</label>
                <input type="number" name="harga" id="harga" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" name="stok" id="stok" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="gambar">Gambar Produk</label>
                <input type="file" name="gambar" id="gambar" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary mt-2">Create</button>
        </form>
    </div>
@endsection
