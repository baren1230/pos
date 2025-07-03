<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    public function index()
    {
        $products = Produk::all();
        $qrisImage = Setting::getImage('qris_image', 'assets/images/default-qris.png');
        return view('kasir.dashboard', compact('products', 'qrisImage'));
    }

    public function transactionHistory()
    {
        $transactions = Transaction::where('user_id', auth()->id())
            ->with('items.produk')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kasir.transactionHistory', compact('transactions'));
    }

    public function addToCart(Request $request)
    {
        $cart = session()->get('cart', []);

        $productId = $request->input('produk_id');
        $quantity = $request->input('quantity', 1);

        $product = Produk::findOrFail($productId);

        // Check if requested quantity is available in stock
        if ($product->stok < $quantity) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Stok produk tidak mencukupi.'], 400);
            }
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi.');
        }

        // Create stock movement record for stock out instead of direct stok decrement
        \App\Models\StockMovement::create([
            'produk_id' => $product->id,
            'type' => 'out',
            'quantity' => $quantity,
            'date' => now()->toDateString(),
            'description' => 'Pengurangan stok melalui penjualan (add to cart)',
        ]);

        // Decrement product stock immediately
        $product->stok -= $quantity;
        $product->save();

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                "produk_id" => $productId,
                "nama_produk" => $product->nama_produk,
                "harga" => $product->harga,
                "quantity" => $quantity
            ];
        }

        session()->put('cart', $cart);

        if ($request->ajax()) {
            return response()->json([
                'success' => 'Produk berhasil ditambahkan ke keranjang.',
                'cart' => $cart,
                'product_stock' => $product->stok,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function removeFromCart($produkId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$produkId])) {
            $quantity = $cart[$produkId]['quantity'];
            // Increment product stock
            $product = Produk::find($produkId);
            if ($product) {
                $product->stok += $quantity;
                $product->save();
            }
            unset($cart[$produkId]);
            session()->put('cart', $cart);
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => 'Produk berhasil dihapus dari keranjang.',
                'cart' => $cart,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    public function clearCart()
    {
        $cart = session()->get('cart', []);

        foreach ($cart as $item) {
            $product = Produk::find($item['produk_id']);
            if ($product) {
                $product->stok += $item['quantity'];
                $product->save();
            }
        }

        session()->forget('cart');

        if (request()->ajax()) {
            return response()->json([
                'success' => 'Keranjang berhasil dikosongkan.',
                'cart' => [],
            ]);
        }

        return redirect()->back()->with('success', 'Keranjang berhasil dikosongkan.');
    }

    public function processTransaction(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Keranjang kosong.'], 400);
            }
            return redirect()->back()->with('error', 'Keranjang kosong.');
        }

        DB::beginTransaction();

        try {
            $totalAmount = 0;
            foreach ($cart as $item) {
                $totalAmount += $item['harga'] * $item['quantity'];
            }

            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'total_amount' => $totalAmount,
                'payment_method' => $request->input('payment_method', 'cash'),
                'status' => 'completed',
            ]);

            foreach ($cart as $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'produk_id' => $item['produk_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['harga'],
                    'subtotal' => $item['harga'] * $item['quantity'],
                ]);

                // Create stock movement record for stock out instead of direct stok decrement
                // Stock already decremented when added to cart, so skip here
                /*
                $product = Produk::find($item['produk_id']);
                if ($product) {
                    \App\Models\StockMovement::create([
                        'produk_id' => $product->id,
                        'type' => 'out',
                        'quantity' => $item['quantity'],
                        'date' => now()->toDateString(),
                        'description' => 'Pengurangan stok melalui penjualan (transaksi)',
                    ]);
                    // Decrement product stock
                    $product->stok -= $item['quantity'];
                    $product->save();
                }
                */
            }

            session()->forget('cart');

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => 'Transaksi berhasil diproses.',
                    'redirect' => route('kasir.receipt', ['transaction' => $transaction->id]),
                ]);
            }

            return redirect()->route('kasir.receipt', ['transaction' => $transaction->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax()) {
                return response()->json(['error' => 'Terjadi kesalahan saat memproses transaksi.'], 500);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses transaksi.');
        }
    }

    public function receipt(Transaction $transaction)
    {
        $transaction->load('items.produk', 'user');
        return view('kasir.receipt', compact('transaction'));
    }
}