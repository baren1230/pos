@extends('layouts.app')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ Breadcrumb ] -->
            @include('admin.supplier.partials.breadcumb', [
                'breadcrumbActive' => 'Supplier',
            ])

            <!-- [ Main Content ] -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">

                        <!-- Header & Button Tambah -->
                        <div class="card-header">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addSupplierModal">
                                Tambah Supplier
                            </button>
                        </div>

                        <!-- Modal Tambah -->
                        <div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <form action="{{ route('admin.supplier.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addSupplierModalLabel">Tambah Supplier</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul class="mb-0">
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            <div class="mb-3">
                                                <label for="nama_supplier" class="form-label">Nama Supplier</label>
                                                <input type="text" class="form-control" id="nama_supplier"
                                                    name="nama_supplier" value="{{ old('nama_supplier') }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="alamat" class="form-label">Alamat</label>
                                                <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="telepon" class="form-label">Telepon</label>
                                                <input type="text" class="form-control" id="telepon" name="telepon"
                                                    value="{{ old('telepon') }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Tabel Supplier -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama Supplier</th>
                                            <th>Alamat</th>
                                            <th>Telepon</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($suppliers as $supplier)
                                            <tr>
                                                <td>{{ $supplier->id }}</td>
                                                <td>{{ $supplier->nama_supplier }}</td>
                                                <td>{{ $supplier->alamat }}</td>
                                                <td>{{ $supplier->telepon }}</td>
                                                <td>
                                                    <!-- Tombol Edit -->
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editSupplierModal{{ $supplier->id }}">
                                                        Edit
                                                    </button>

                                                    <!-- Modal Edit -->
                                                    <div class="modal fade" id="editSupplierModal{{ $supplier->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="editSupplierModalLabel{{ $supplier->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-md">
                                                            <div class="modal-content">
                                                                <form
                                                                    action="{{ route('admin.supplier.update', $supplier->id) }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="editSupplierModalLabel{{ $supplier->id }}">
                                                                            Edit Supplier</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label for="nama_supplier_{{ $supplier->id }}"
                                                                                class="form-label">Nama Supplier</label>
                                                                            <input type="text" class="form-control"
                                                                                id="nama_supplier_{{ $supplier->id }}"
                                                                                name="nama_supplier"
                                                                                value="{{ $supplier->nama_supplier }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="alamat_{{ $supplier->id }}"
                                                                                class="form-label">Alamat</label>
                                                                            <textarea class="form-control" id="alamat_{{ $supplier->id }}" name="alamat" rows="3" required>{{ $supplier->alamat }}</textarea>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="telepon_{{ $supplier->id }}"
                                                                                class="form-label">Telepon</label>
                                                                            <input type="text" class="form-control"
                                                                                id="telepon_{{ $supplier->id }}"
                                                                                name="telepon"
                                                                                value="{{ $supplier->telepon }}" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Simpan</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Tombol Hapus -->
                                                    <form action="{{ route('admin.supplier.destroy', $supplier->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus supplier ini?')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Tidak ada data supplier.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
