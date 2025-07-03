<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Transaction;
use App\Models\Expense;
use App\Models\Category;
use App\Models\Suplayer;

class LaporanController extends Controller
{
    public function stokProduk(Request $request)
    {
        $query = Produk::with('category');

        if ($request->has('kategori_id') && $request->kategori_id != '') {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->has('ukuran') && $request->ukuran != '') {
            $query->where('ukuran', $request->ukuran);
        }

        if ($request->has('warna') && $request->warna != '') {
            $query->where('warna', $request->warna);
        }

        $products = $query->get();

        // Calculate total quantity sold for each product
        $soldQuantities = \App\Models\TransactionItem::selectRaw('produk_id, SUM(quantity) as total_sold')
            ->groupBy('produk_id')
            ->pluck('total_sold', 'produk_id');

        // Adjust stock by subtracting sold quantities using stok_akhir attribute
        foreach ($products as $product) {
            $sold = $soldQuantities->get($product->id, 0);
            $product->remaining_stock = max($product->stok_akhir - $sold, 0);
        }

        $categories = Category::all();

        $ukuranList = Produk::select('ukuran')->distinct()->pluck('ukuran');

        $warnaList = Produk::select('warna')->distinct()->pluck('warna');

        return view('admin.laporan.stok_produk', compact('products', 'categories', 'ukuranList', 'warnaList'));
    }

    public function pembelian(Request $request)
    {
        $query = Produk::with('supplier');

        if ($request->has('supplier_id') && $request->supplier_id != '') {
            $supplierId = $request->input('supplier_id');
            $query->where('supplier_id', $supplierId);
        }

        $products = $query->get();

        $start = $request->input('start_date');
        $end = $request->input('end_date');

        // Calculate stock from purchases (PembelianItem) grouped by produk_id within date range
        $purchaseStocksQuery = \App\Models\PembelianItem::selectRaw('produk_id, SUM(quantity) as total_quantity')
            ->join('pembelians', 'pembelian_items.pembelian_id', '=', 'pembelians.id');

        if ($start && $end) {
            $purchaseStocksQuery->whereBetween('pembelians.tanggal', [$start, $end]);
        }

        if ($request->has('supplier_id') && $request->supplier_id != '') {
            $purchaseStocksQuery->where('pembelians.supplier_id', $supplierId);
        }

        $purchaseStocks = $purchaseStocksQuery->groupBy('produk_id')->pluck('total_quantity', 'produk_id');

        $suppliers = \App\Models\Supplier::all();

        return view('admin.laporan.pembelian', compact('products', 'suppliers', 'purchaseStocks'));
    }

    public function penjualan(Request $request)
    {
        $query = Transaction::with('items.produk');

        if ($request->has('start_date') && $request->has('end_date')) {
            $start = $request->input('start_date');
            $end = $request->input('end_date');
            $query->whereBetween('created_at', [$start . ' 00:00:00', $end . ' 23:59:59']);
        }

        $transactions = $query->get();

        // Group items by product id
        $groupedItems = [];

        foreach ($transactions as $transaction) {
            foreach ($transaction->items as $item) {
                $productId = $item->produk->id ?? null;
                if ($productId) {
                    if (!isset($groupedItems[$productId])) {
                        $groupedItems[$productId] = [
                            'nama_produk' => $item->produk->nama_produk ?? '-',
                            'jumlah_terjual' => 0,
                            'harga_satuan' => $item->price,
                            'total' => 0,
                        ];
                    }
                    $groupedItems[$productId]['jumlah_terjual'] += $item->quantity;
                    $groupedItems[$productId]['total'] += $item->subtotal;
                }
            }
        }

        return view('admin.laporan.penjualan', compact('groupedItems', 'transactions'));
    }

    public function pengeluaran(Request $request)
    {
        $query = Expense::query();

        if ($request->has('start_date') && $request->has('end_date')) {
            $start = $request->input('start_date');
            $end = $request->input('end_date');
            $query->whereBetween('tanggal', [$start, $end]);
        }

        $expenses = $query->get();

        $total = $expenses->sum('jumlah');

        return view('admin.laporan.pengeluaran', compact('expenses', 'total'));
    }

    public function storePengeluaran(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
        ]);

        Expense::create($validated);

        return redirect()->route('laporan.pengeluaran')->with('success', 'Pengeluaran berhasil ditambahkan.');
    }

    public function labaRugi(Request $request)
    {
        $start = $request->input('start_date');
        $end = $request->input('end_date');

        // Query sales (income)
        $salesQuery = Transaction::with('items.produk');
        if ($start && $end) {
            $salesQuery->whereBetween('created_at', [$start . ' 00:00:00', $end . ' 23:59:59']);
        }
        $sales = $salesQuery->get();

        // Calculate total income and total quantity sold
        $totalIncome = 0;
        $totalQuantitySold = 0;
        foreach ($sales as $sale) {
            foreach ($sale->items as $item) {
                $totalIncome += $item->subtotal ?? ($item->jumlah * $item->produk->harga_jual);
                $totalQuantitySold += $item->jumlah;
            }
        }

        // Query expenses
        $expenseQuery = Expense::query();
        if ($start && $end) {
            $expenseQuery->whereBetween('tanggal', [$start, $end]);
        }
        $expenses = $expenseQuery->get();

        $totalExpenses = $expenses->sum('jumlah');

        // Calculate total purchase cost (harga beli produk x stok)
        $purchaseStocksQuery = \App\Models\PembelianItem::selectRaw('produk_id, SUM(quantity) as total_quantity')
            ->join('pembelians', 'pembelian_items.pembelian_id', '=', 'pembelians.id');

        if ($start && $end) {
            $purchaseStocksQuery->whereBetween('pembelians.tanggal', [$start, $end]);
        }

        $purchaseStocks = $purchaseStocksQuery->groupBy('produk_id')->pluck('total_quantity', 'produk_id');

        $produkQuery = Produk::query();
        if ($start && $end) {
            $produkQuery->whereBetween('tanggal_masuk', [$start, $end]);
        }
        $produks = $produkQuery->get();

        $totalPurchaseCost = 0;
        foreach ($produks as $produk) {
            $purchaseStock = $purchaseStocks->get($produk->id, 0);
            $totalPurchaseCost += ($produk->harga_beli * $purchaseStock);
        }

        // Add total purchase cost to total expenses
        // $totalExpenses += $totalPurchaseCost;

        // Calculate profit or loss
        $profitOrLoss = $totalIncome - ($totalExpenses + $totalPurchaseCost);

        return view('admin.laporan.laba_rugi', compact('sales', 'expenses', 'totalIncome', 'totalExpenses', 'profitOrLoss', 'start', 'end', 'totalPurchaseCost', 'totalQuantitySold'));
    }
}