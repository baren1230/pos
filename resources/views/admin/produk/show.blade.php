@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">Detail Produk</h1>

        <div class="bg-white shadow rounded p-6">
            <h2 class="text-xl font-semibold mb-2">{{ $produk->nama_produk }}</h2>
            <p><strong>Kategori:</strong> {{ $produk->kategori ?? 'Tidak ada kategori' }}</p>
            <p><strong>Deskripsi:</strong> {{ $produk->deskripsi ?? 'Tidak ada deskripsi' }}</p>
            <p><strong>Harga:</strong> Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
            <p><strong>Stok:</strong> {{ $produk->stok }}</p>
        </div>

        <div class="mt-6">
            <a href="{{ route('produk.index') }}" class="text-blue-600 hover:underline">Kembali ke daftar produk</a>
        </div>
    </div>
@endsection
