<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('produks', 'kode_produk')) {
            // Membersihkan duplikat dan nilai kosong pada kolom kode_produk
            $duplicates = DB::table('produks')
                ->select('kode_produk')
                ->groupBy('kode_produk')
                ->havingRaw('COUNT(*) > 1')
                ->pluck('kode_produk');

            foreach ($duplicates as $kode) {
                $products = DB::table('produks')->where('kode_produk', $kode)->get();
                foreach ($products as $index => $product) {
                    $newKode = $kode . '-' . ($index + 1);
                    DB::table('produks')->where('id', $product->id)->update(['kode_produk' => $newKode]);
                }
            }

            $emptyKodeProducts = DB::table('produks')->whereNull('kode_produk')->orWhere('kode_produk', '')->get();
            foreach ($emptyKodeProducts as $product) {
                $newKode = 'kode-' . $product->id;
                DB::table('produks')->where('id', $product->id)->update(['kode_produk' => $newKode]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak ada rollback khusus untuk pembersihan data ini
    }
};
