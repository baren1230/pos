<div class="col-md-4">
    <div class="card h-100 shadow-sm p-2">
        <img src="{{ $product->gambar && file_exists(public_path('storage/' . $product->gambar)) ? asset('storage/' . $product->gambar) : asset('assets/images/default-product.png') }}"
            class="card-img-top mb-2 rounded" alt="{{ $product->nama_produk }}" style="height: 150px; object-fit: cover">
        <div class="card-body d-flex flex-column p-2">
            <h6 class="card-title">{{ $product->nama_produk }}</h6>
            <p class="card-text text-muted">
                Harga: Rp {{ number_format($product->harga, 0, ',', '.') }}
            </p>
            <p class="card-text text-muted">
                Stok: {{ $product->stok }}
            </p>
            @if ($product->stok > 0)
                <form action="{{ route('kasir.addToCart') }}" method="POST" class="mt-auto">
                    @csrf
                    <input type="hidden" name="produk_id" value="{{ $product->id }}">
                    <div class="input-group mb-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-cart-plus me-1"></i> Tambah
                        </button>
                    </div>
                </form>
            @else
                <div class="alert alert-danger mt-auto p-2 text-center" role="alert">
                    Stok habis, tidak bisa dijual
                </div>
            @endif
        </div>
    </div>
</div>
