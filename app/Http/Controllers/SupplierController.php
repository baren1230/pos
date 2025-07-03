<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * Display a listing of the supplier.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return view('admin.supplier.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
        ]);

        Supplier::create($validated);

        return redirect()->route('admin.supplier.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $validated = $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
        ]);

        $supplier->update($validated);

        return redirect()->route('admin.supplier.index')->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('admin.supplier.index')->with('success', 'Supplier berhasil dihapus.');
    }
}