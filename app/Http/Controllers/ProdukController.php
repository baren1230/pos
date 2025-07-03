<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the produk.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = Produk::with(['category', 'supplier'])->get();
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('admin.produk.index', compact('products', 'categories', 'suppliers'));
    }

    /**
     * Show the form for creating a new produk.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('admin.produk.create', compact('categories', 'suppliers'));
    }

    /**
     * Store a newly created produk in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori_id' => 'nullable|integer|exists:categories,id',
            'supplier_id' => 'nullable|integer|exists:suppliers,id',
            'deskripsi' => 'nullable|string',
            'harga_beli' => 'required|numeric',
            'harga' => 'required|numeric',
            'variasi' => 'nullable|string',
            'stok' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            $imagePath = $request->file('gambar')->store('produk', 'public');
            $data['gambar'] = $imagePath;
        }

        // Create Produk record
        $produk = Produk::create($data);

        // Create pembelian record
        $pembelian = \App\Models\Pembelian::create([
            'supplier_id' => $data['supplier_id'],
            'tanggal' => now()->toDateString(),
            'total_amount' => $data['harga_beli'] * $data['stok'],
        ]);

        // Create pembelian_items record
        \App\Models\PembelianItem::create([
            'pembelian_id' => $pembelian->id,
            'produk_id' => $produk->id,
            'quantity' => $data['stok'],
            'price' => $data['harga_beli'],
            'subtotal' => $data['harga_beli'] * $data['stok'],
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk created successfully.');
    }

    /**
     * Show the form for editing the specified produk.
     *
     * @param  Produk  $produk
     * @return \Illuminate\View\View
     */
    public function edit(Produk $produk)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('admin.produk.produk_edit', compact('produk', 'categories', 'suppliers'));
    }

    /**
     * Update the specified produk in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Produk  $produk
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori_id' => 'nullable|integer|exists:categories,id',
            'supplier_id' => 'nullable|integer|exists:suppliers,id',
            'deskripsi' => 'nullable|string',
            'harga_beli' => 'required|numeric',
            'harga' => 'required|numeric',
            'variasi' => 'nullable|string',
            'stok' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $imagePath = $request->file('gambar')->store('produk', 'public');
            $data['gambar'] = $imagePath;
        }

        $produk->update($data);

        return redirect()->route('produk.index')->with('success', 'Produk updated successfully.');
    }

    /**
     * Remove the specified produk from storage.
     *
     * @param  Produk  $produk
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Produk $produk)
    {
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk deleted successfully.');
    }

    /**
     * Display the kategori page.
     *
     * @return \Illuminate\View\View
     */
    public function kategori()
    {
        return redirect()->route('kategori.index');
    }

    /**
     * Display the specified produk.
     *
     * @param  Produk  $produk
     * @return \Illuminate\View\View
     */
    public function show(Produk $produk)
    {
        return view('admin.produk.show', compact('produk'));
    }

    /**
     * Display the produk view page.
     *
     * @return \Illuminate\View\View
     */
    public function produkView()
    {
        $products = Produk::with(['category', 'supplier'])->get();
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('admin.produk.produk', compact('products', 'categories', 'suppliers'));
    }

    /**
     * Handle purchase to add stock for a product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Produk  $produk
     * @return \Illuminate\Http\RedirectResponse
     */
    public function purchase(Request $request, Produk $produk)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'harga_beli' => 'required|numeric',
        ]);

        $jumlah = $request->input('jumlah');
        $supplierId = $request->input('supplier_id');
        $hargaBeli = $request->input('harga_beli');

        // Create pembelian record
        $pembelian = \App\Models\Pembelian::create([
            'supplier_id' => $supplierId,
            'tanggal' => now()->toDateString(),
            'total_amount' => $jumlah * $hargaBeli,
        ]);

        // Create pembelian_items record
        \App\Models\PembelianItem::create([
            'pembelian_id' => $pembelian->id,
            'produk_id' => $produk->id,
            'quantity' => $jumlah,
            'price' => $hargaBeli,
            'subtotal' => $jumlah * $hargaBeli,
        ]);

        // Create stock movement record for stock in
        \App\Models\StockMovement::create([
            'produk_id' => $produk->id,
            'type' => 'in',
            'quantity' => $jumlah,
            'date' => now()->toDateString(),
            'description' => 'Penambahan stok melalui pembelian',
        ]);

        // Update produk stock
        $produk->increment('stok', $jumlah);

        return redirect()->route('produk.index')->with('success', 'Stok produk berhasil ditambah dan pembelian dicatat.');
    }
}