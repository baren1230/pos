<div class="modal fade" id="purchaseStockModal{{ $product->id }}" tabindex="-1"
    aria-labelledby="purchaseStockModalLabel{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="{{ route('produk.purchase', $product->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="purchaseStockModalLabel{{ $product->id }}">
                        Tambah Stok Produk
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="jumlah_{{ $product->id }}" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah_{{ $product->id }}" name="jumlah"
                            min="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
