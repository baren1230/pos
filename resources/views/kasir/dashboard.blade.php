@extends('layouts.app')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            @include('kasir.partials.breadcrumb', [
                'breadcrumbActive' => 'Kasir',
            ])
            <div class="row g-4">
                <!-- Product List -->
                <div class="col-md-8">
                    <div class="card shadow p-3">
                        <div class="card-header mb-3">
                            <h5 class="mb-0"><i class="fas fa-box me-2"></i> Daftar Produk</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                @foreach ($products as $product)
                                    @include('kasir.partials.product_card', ['product' => $product])
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                @include('kasir.partials.cart')
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            function showAlert(message, type = 'success') {
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
                alertDiv.role = 'alert';
                alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
                const container = document.querySelector('.pc-content');
                container.prepend(alertDiv);
                setTimeout(() => {
                    alertDiv.classList.remove('show');
                    alertDiv.classList.add('hide');
                    alertDiv.remove();
                }, 5000);
            }

            function updateCart() {
                fetch("{{ url()->current() }}", {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newCart = doc.querySelector('.col-md-4 > .card.shadow.p-3');
                        const oldCart = document.querySelector('.col-md-4 > .card.shadow.p-3');
                        if (newCart && oldCart) {
                            oldCart.innerHTML = newCart.innerHTML;
                            attachCartFormHandlers();
                        }
                    });
            }

            function updateProductStock(productId, stock) {
                const stockElem = document.querySelector(`#product-stock-${productId}`);
                if (stockElem) {
                    stockElem.textContent = `Stok: ${stock}`;
                    if (stock <= 0) {
                        const form = document.querySelector(`#add-to-cart-form-${productId}`);
                        if (form) {
                            form.querySelector('button[type="submit"]').disabled = true;
                            if (!form.querySelector('.alert-danger')) {
                                form.insertAdjacentHTML('beforeend',
                                    '<div class="alert alert-danger mt-2 p-2 text-center">Stok habis, tidak bisa dijual</div>'
                                );
                            }
                        }
                    }
                }
            }

            function handleAddToCartForm(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(form);
                    fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                showAlert(data.error, 'danger');
                            } else {
                                showAlert(data.success, 'success');
                                updateCart();
                                updateProductStock(formData.get('produk_id'), data.product_stock);
                            }
                        })
                        .catch(() => {
                            showAlert('Terjadi kesalahan jaringan.', 'danger');
                        });
                });
            }

            function handleRemoveFromCartForms() {
                // Fix selector to match forms with action containing remove-from-cart
                const forms = document.querySelectorAll('form[action*="/kasir/remove-from-cart/"]');
                forms.forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const formData = new FormData(form);
                        fetch(form.action, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'X-Requested-With': 'XMLHttpRequest',
                                },
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.error) {
                                    showAlert(data.error, 'danger');
                                } else {
                                    showAlert(data.success, 'success');
                                    updateCart();
                                }
                            })
                            .catch(() => {
                                showAlert('Terjadi kesalahan jaringan.', 'danger');
                            });
                    });
                });
            }

            function handleClearCartForm() {
                const form = document.querySelector('form[action="{{ route('kasir.clearCart') }}"]');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        fetch(form.action, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'X-Requested-With': 'XMLHttpRequest',
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.error) {
                                    showAlert(data.error, 'danger');
                                } else {
                                    showAlert(data.success, 'success');
                                    updateCart();
                                }
                            })
                            .catch(() => {
                                showAlert('Terjadi kesalahan jaringan.', 'danger');
                            });
                    });
                }
            }

            function handleProcessTransactionForm() {
                const form = document.querySelector('form[action="{{ route('kasir.processTransaction') }}"]');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const formData = new FormData(form);
                        fetch(form.action, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'X-Requested-With': 'XMLHttpRequest',
                                },
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.error) {
                                    showAlert(data.error, 'danger');
                                } else if (data.redirect) {
                                    window.location.href = data.redirect;
                                } else {
                                    showAlert(data.success, 'success');
                                    updateCart();
                                }
                            })
                            .catch(() => {
                                showAlert('Terjadi kesalahan jaringan.', 'danger');
                            });
                    });
                }
            }

            function attachCartFormHandlers() {
                handleRemoveFromCartForms();
                handleClearCartForm();
                handleProcessTransactionForm();
            }

            function attachAddToCartHandlers() {
                const forms = document.querySelectorAll('form[id^="add-to-cart-form-"]');
                forms.forEach(form => {
                    handleAddToCartForm(form);
                });
            }

            attachAddToCartHandlers();
            attachCartFormHandlers();
        });
    </script>
@endsection
