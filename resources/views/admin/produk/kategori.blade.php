@extends('layouts.app')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ Breadcrumb ] -->
            @php
                $breadcrumbs = [
                    ['label' => 'Home', 'url' => url('/dashboard')],
                    ['label' => 'Kategori', 'url' => route('kategori.index')],
                ];
            @endphp

            @include('admin.produk.partials.breadcrumb', [
                'pageTitle' => 'Kategori',
                'breadcrumbs' => $breadcrumbs,
            ])

            <!-- [ Main Content ] -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <!-- Card Header -->
                        <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div>
                                <!-- Button: Create Category -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addCategoryModal">
                                    Tambah Kategori
                                </button>

                                <!-- Button: Back to Produk -->
                                <a href="{{ route('produk.index') }}" class="btn btn-secondary">Produk</a>
                                <!-- Modal: Add Category -->
                                @include('admin.produk.partials.add_category_modal')
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Category Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($categories as $category)
                                            <tr>
                                                <td>{{ $category->id }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td class="d-flex flex-wrap gap-1">
                                                    <!-- Button: Edit -->
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editCategoryModal{{ $category->id }}">
                                                        Edit
                                                    </button>

                                                    <!-- Modal: Edit Category -->
                                                    @include('admin.produk.partials.edit_category_modal', [
                                                        'category' => $category,
                                                    ])

                                                    <!-- Button: Delete -->
                                                    <form action="{{ route('kategori.destroy', $category->id) }}"
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
                                                <td colspan="3" class="text-center">No categories found.</td>
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
