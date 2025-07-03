<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;
use App\Models\Produk;

class SupplierProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some suppliers
        $supplier1 = Supplier::create(['nama_supplier' => 'Supplier A']);
        $supplier2 = Supplier::create(['nama_supplier' => 'Supplier B']);
        $supplier3 = Supplier::create(['nama_supplier' => 'Supplier C']);

        // Create some products with supplier relation
        Produk::create([
            'nama_produk' => 'Produk 1',
            'kategori_id' => 1,
            'supplier_id' => $supplier1->id,
            'deskripsi' => 'Deskripsi produk 1',
            'harga_beli' => 10000,
            'harga' => 15000,
            'stok' => 10,
            'gambar' => null,
        ]);

        Produk::create([
            'nama_produk' => 'Produk 2',
            'kategori_id' => 1,
            'supplier_id' => $supplier2->id,
            'deskripsi' => 'Deskripsi produk 2',
            'harga_beli' => 20000,
            'harga' => 25000,
            'stok' => 5,
            'gambar' => null,
        ]);

        Produk::create([
            'nama_produk' => 'Produk 3',
            'kategori_id' => 2,
            'supplier_id' => $supplier3->id,
            'deskripsi' => 'Deskripsi produk 3',
            'harga_beli' => 15000,
            'harga' => 22000,
            'stok' => 8,
            'gambar' => null,
        ]);
    }
}
