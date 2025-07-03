@extends('layouts.app')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ Breadcrumb ] -->
            @include('admin.laporan.partials.breadcrumb', [
                'breadcrumbTitle' => 'Pengeluaran',
                'breadcrumbActive' => 'Pengeluaran',
            ])

            <!-- [ Main Content ] -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">

                        <!-- Header & Button Tambah -->
                        <div class="card-header">
                            <form method="GET" action="{{ route('laporan.pengeluaran') }}"
                                class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <label for="start_date" class="col-form-label">Tanggal Mulai:</label>
                                </div>
                                <div class="col-auto">
                                    <input type="date" id="start_date" name="start_date" class="form-control"
                                        value="{{ request('start_date') }}">
                                </div>
                                <div class="col-auto">
                                    <label for="end_date" class="col-form-label">Tanggal Akhir:</label>
                                </div>
                                <div class="col-auto">
                                    <input type="date" id="end_date" name="end_date" class="form-control"
                                        value="{{ request('end_date') }}">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('laporan.pengeluaran') }}" class="btn btn-secondary">Reset</a>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#addExpenseModal">
                                        Tambah Pengeluaran
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Modal Tambah -->
                        <div class="modal fade" id="addExpenseModal" tabindex="-1" aria-labelledby="addExpenseModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <form action="{{ route('laporan.pengeluaran.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addExpenseModalLabel">Tambah Pengeluaran</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="tanggal" class="form-label">Tanggal</label>
                                                <input type="date" class="form-control" id="tanggal" name="tanggal"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="keterangan" class="form-label">Keterangan</label>
                                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="jumlah" class="form-label">Jumlah</label>
                                                <input type="number" class="form-control" id="jumlah" name="jumlah"
                                                    required min="0" step="0.01">
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

                        <!-- Tabel Pengeluaran -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tanggal</th>
                                            <th>Keterangan</th>
                                            <th>Jumlah</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($expenses as $expense)
                                            <tr>
                                                <td>{{ $expense->id }}</td>
                                                <td>{{ \Carbon\Carbon::parse($expense->tanggal)->format('d-m-Y') }}</td>
                                                <td>{{ $expense->keterangan }}</td>
                                                <td>Rp {{ number_format($expense->jumlah, 2, ',', '.') }}</td>
                                                <td>
                                                    <!-- Tombol Edit -->
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editExpenseModal{{ $expense->id }}">
                                                        Edit
                                                    </button>

                                                    <!-- Modal Edit -->
                                                    <div class="modal fade" id="editExpenseModal{{ $expense->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="editExpenseModalLabel{{ $expense->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-md">
                                                            <div class="modal-content">
                                                                <form
                                                                    action="{{ route('laporan.pengeluaran.update', $expense->id) }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="editExpenseModalLabel{{ $expense->id }}">
                                                                            Edit Pengeluaran</h5>
                                                                        <button type="button" class="btn btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label for="tanggal_{{ $expense->id }}"
                                                                                class="form-label">Tanggal</label>
                                                                            <input type="date" class="form-control"
                                                                                id="tanggal_{{ $expense->id }}"
                                                                                name="tanggal"
                                                                                value="{{ $expense->tanggal }}" required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="keterangan_{{ $expense->id }}"
                                                                                class="form-label">Keterangan</label>
                                                                            <textarea class="form-control" id="keterangan_{{ $expense->id }}" name="keterangan" rows="3" required>{{ $expense->keterangan }}</textarea>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="jumlah_{{ $expense->id }}"
                                                                                class="form-label">Jumlah</label>
                                                                            <input type="number" class="form-control"
                                                                                id="jumlah_{{ $expense->id }}"
                                                                                name="jumlah"
                                                                                value="{{ $expense->jumlah }}" required
                                                                                min="0" step="0.01">
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
                                                    <form
                                                        action="{{ route('laporan.pengeluaran.destroy', $expense->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus pengeluaran ini?')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Tidak ada data pengeluaran.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" class="text-end">Total</th>
                                            <th>Rp {{ number_format($total, 2, ',', '.') }}</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
