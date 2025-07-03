<div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1"
    aria-labelledby="editProductModalLabel{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('produk.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_produk_{{ $product->id }}" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" name="nama_produk"
                            id="nama_produk_{{ $product->id }}" value="{{ $product->nama_produk }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="kategori_{{ $product->id }}" class="form-label">Kategori</label>
                        <select class="form-select" name="kategori_id" id="kategori_{{ $product->id }}" required>
                            <option value="" disabled>Pilih
                                Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $product->kategori_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="supplier_{{ $product->id }}" class="form-label">Supplier</label>
                        <select class="form-select" name="supplier_id" id="supplier_{{ $product->id }}" required>
                            <option value="" disabled>Pilih Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    {{ $product->supplier_id == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->nama_supplier }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="harga_beli_{{ $product->id }}" class="form-label">Harga Beli</label>
                        <input type="number" class="form-control" name="harga_beli"
                            id="harga_beli_{{ $product->id }}" step="0.01" value="{{ $product->harga_beli }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="harga_{{ $product->id }}" class="form-label">Harga Jual</label>
                        <input type="number" class="form-control" name="harga" id="harga_{{ $product->id }}"
                            step="0.01" value="{{ $product->harga }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="gambar_{{ $product->id }}" class="form-label">Gambar</label>
                        <input type="file" class="form-control" name="gambar" id="gambar_{{ $product->id }}"
                            accept="image/*">
                        @if ($product->gambar)
                            <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}"
                                width="100" class="mt-2">
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="ukuran_{{ $product->id }}" class="form-label">Ukuran</label>
                        <input type="text" class="form-control" name="ukuran" id="ukuran_{{ $product->id }}"
                            value="{{ $product->ukuran }}">
                    </div>

                    <div class="mb-3">
                        <label for="warna_{{ $product->id }}" class="form-label">Warna</label>
                        <input type="text" class="form-control" name="warna" id="warna_{{ $product->id }}"
                            value="{{ $product->warna }}">
                    </div>

                    <div class="mb-3">
                        <label for="stok_{{ $product->id }}" class="form-label">Stok</label>
                        <input type="number" class="form-control" name="stok" id="stok_{{ $product->id }}"
                            value="{{ $product->stok }}" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
