<div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1"
    aria-labelledby="editCategoryModalLabel{{ $category->id }}" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel{{ $category->id }}">Edit Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('kategori.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name_{{ $category->id }}" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="name_{{ $category->id }}" name="name"
                            value="{{ $category->name }}" required>
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
