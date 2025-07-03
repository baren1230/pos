<div class="col-md-4">
    <div class="card shadow p-3">
        <div class="card-header d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i> Keranjang</h5>
            <form action="{{ route('kasir.clearCart') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash me-1"></i> Kosongkan
                </button>
            </form>
        </div>
        <div class="card-body">
            @if (session('cart') && count(session('cart')) > 0)
                <div class="table-responsive mb-3">
                    <table class="table table-bordered table-sm align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach (session('cart') as $item)
                                @php
                                    $subtotal = $item['harga'] * $item['quantity'];
                                    $total += $subtotal;
                                @endphp
                                <tr>
                                    <td>{{ $item['nama_produk'] }}</td>
                                    <td>{{ $item['quantity'] }}</td>
                                    <td>Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('kasir.removeFromCart', $item['produk_id']) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total</strong></td>
                                <td colspan="2"><strong>Rp
                                        {{ number_format($total, 0, ',', '.') }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <form action="{{ route('kasir.processTransaction') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="payment_method" class="form-label"><i class="fas fa-wallet me-1"></i>
                            Metode Pembayaran</label>
                        <select name="payment_method" id="payment_method" class="form-select" required>
                            <option value="cash">Tunai</option>
                            <option value="qris">QRIS</option>
                        </select>
                        <div id="qris-barcode" class="mt-3" style="display: none; text-align: center;">
                            @if (!empty($qrisImage))
                                <div style="margin-top: 10px;">
                                    <img src="{{ asset('storage/' . $qrisImage) }}" alt="QRIS Barcode"
                                        class="img-fluid" />
                                </div>
                            @else
                                <div style="margin-left: 10px;">
                                    <img src="{{ asset('assets/images/default-qris.png') }}" alt="QRIS Barcode"
                                        class="img-fluid" />
                                </div>
                            @endif
                        </div>
                        <div id="cash-payment" class="mt-3" style="display: none">
                            <label for="uang_diterima" class="form-label"><i class="fas fa-money-bill me-1"></i> Uang
                                Diterima</label>
                            <input type="number" id="uang_diterima" name="uang_diterima" class="form-control"
                                min="{{ $total }}">
                            <label for="uang_kembali" class="form-label mt-2"><i class="fas fa-exchange-alt me-1"></i>
                                Uang Kembali</label>
                            <input type="text" id="uang_kembali" class="form-control" readonly value="Rp 0">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-cash-register me-1"></i> Proses Transaksi
                    </button>
                </form>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const paymentMethodSelect = document.getElementById('payment_method');
                        const qrisBarcode = document.getElementById('qris-barcode');
                        const cashPayment = document.getElementById('cash-payment');
                        const uangDiterimaInput = document.getElementById('uang_diterima');
                        const uangKembaliInput = document.getElementById('uang_kembali');
                        const totalBayar = {{ $total }};

                        function togglePaymentFields() {
                            if (paymentMethodSelect.value === 'qris') {
                                qrisBarcode.style.display = 'block';
                                cashPayment.style.display = 'none';
                                uangDiterimaInput.required = false;
                            } else if (paymentMethodSelect.value === 'cash') {
                                qrisBarcode.style.display = 'none';
                                cashPayment.style.display = 'block';
                                uangDiterimaInput.required = true;
                            } else {
                                qrisBarcode.style.display = 'none';
                                cashPayment.style.display = 'none';
                                uangDiterimaInput.required = false;
                            }
                        }

                        function calculateChange() {
                            const uangDiterima = parseInt(uangDiterimaInput.value) || 0;
                            const uangKembali = uangDiterima - totalBayar;
                            uangKembaliInput.value = 'Rp ' + uangKembali.toLocaleString('id-ID');
                        }
                        paymentMethodSelect.addEventListener('change', togglePaymentFields);
                        uangDiterimaInput.addEventListener('input', calculateChange);
                        // Initial check
                        togglePaymentFields();
                    });
                </script>
            @else
                <p class="text-center text-muted"><i class="fas fa-empty-cart me-1"></i> Keranjang masih
                    kosong</p>
            @endif
        </div>
    </div>
</div>
