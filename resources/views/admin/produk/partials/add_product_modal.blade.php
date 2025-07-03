<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_produk" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
                    </div>

                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori_id" name="kategori_id" required>
                            <option value="" selected disabled>Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="supplier_id" class="form-label">Supplier</label>
                        <select class="form-select" id="supplier_id" name="supplier_id" required>
                            <option value="" selected disabled>Pilih Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="harga_beli" class="form-label">Harga Beli</label>
                        <input type="number" class="form-control" id="harga_beli" name="harga_beli" step="0.01"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga Jual</label>
                        <input type="number" class="form-control" id="harga" name="harga" step="0.01"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="ukuran" class="form-label">Ukuran</label>
                        <input type="text" class="form-control" id="ukuran" name="ukuran">
                    </div>

                    <div class="mb-3">
                        <label for="warna" class="form-label">Warna</label>
                        <input type="text" class="form-control" id="warna" name="warna">
                    </div>

                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="stok" name="stok" required>
                    </div>

                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
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
