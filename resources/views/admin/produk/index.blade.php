@extends('layouts.app')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ Breadcrumb ] -->
            @include('admin.produk.partials.breadcrumb', [
                'breadcrumbActive' => 'Managemen Produk',
            ])

            <!-- [ Main Content ] -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <!-- Card Header -->
                        <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div>
                                <!-- Button: Create Product -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addProductModal">
                                    Tambah Produk
                                </button>
                                <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kategori</a>
                                <!-- Modal: Add Product -->
                                @include('admin.produk.partials.add_product_modal', [
                                    'categories' => $categories,
                                    'suppliers' => $suppliers,
                                ])
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama Produk</th>
                                            <th>Kategori</th>
                                            <th>Supplier</th>
                                            <th>Ukuran</th>
                                            <th>Warna</th>
                                            <th>Gambar</th>
                                            <th>Harga Jual</th>
                                            <th>Stok</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($products as $product)
                                            <tr>
                                                <td>{{ $product->id }}</td>
                                                <td>{{ $product->nama_produk }}</td>
                                                <td>{{ $product->category->name ?? '-' }}</td>
                                                <td>{{ $product->supplier->nama_supplier ?? '-' }}</td>
                                                <td>{{ $product->ukuran }}</td>
                                                <td>{{ $product->warna }}</td>
                                                <td>
                                                    @if ($product->gambar)
                                                        <img src="{{ asset('storage/' . $product->gambar) }}"
                                                            alt="{{ $product->nama_produk }}" width="50">
                                                    @else
                                                        <span class="text-muted">No Image</span>
                                                    @endif
                                                </td>
                                                <td>{{ number_format($product->harga, 2) }}</td>
                                                <td>{{ $product->stok }}</td>
                                                <td class="d-flex flex-wrap gap-1">
                                                    <!-- Button: Edit -->
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editProductModal{{ $product->id }}">
                                                        Edit
                                                    </button>

                                                    <!-- Modal: Edit Product -->
                                                    @include('admin.produk.partials.edit_product_modal', [
                                                        'product' => $product,
                                                        'categories' => $categories,
                                                        'suppliers' => $suppliers,
                                                    ])

                                                    <!-- Button: Tambah Stok -->
                                                    {{-- <button type="button" class="btn btn-sm btn-success"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#purchaseStockModal{{ $product->id }}">
                                                        Tambah Stok
                                                    </button> --}}

                                                    <!-- Modal: Purchase Stock -->
                                                    @include('admin.produk.partials.purchase_stock_modal', [
                                                        'product' => $product,
                                                    ])

                                                    <!-- Button: Delete -->
                                                    <form action="{{ route('produk.destroy', $product->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure?')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="11" class="text-center">No products found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- /.card-body -->
                    </div> <!-- /.card -->
                </div> <!-- /.col -->
            </div> <!-- /.row -->
        </div> <!-- /.pc-content -->
    </div> <!-- /.pc-container -->
@endsection
