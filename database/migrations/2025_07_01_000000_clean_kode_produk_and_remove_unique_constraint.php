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
            // Clean duplicate or empty kode_produk values
            $duplicates = DB::table('produks')
                ->select('kode_produk')
                ->groupBy('kode_produk')
                ->havingRaw('COUNT(*) > 1')
                ->pluck('kode_produk');

            foreach ($duplicates as $kode) {
                // Update duplicate kode_produk to unique values by appending id
                $products = DB::table('produks')->where('kode_produk', $kode)->get();
                foreach ($products as $index => $product) {
                    $newKode = $kode . '-' . ($index + 1);
                    DB::table('produks')->where('id', $product->id)->update(['kode_produk' => $newKode]);
                }
            }

            // Update empty kode_produk to unique values
            $emptyKodeProducts = DB::table('produks')->whereNull('kode_produk')->orWhere('kode_produk', '')->get();
            foreach ($emptyKodeProducts as $product) {
                $newKode = 'kode-' . $product->id;
                DB::table('produks')->where('id', $product->id)->update(['kode_produk' => $newKode]);
            }

            // Drop unique constraint on kode_produk
            Schema::table('produks', function (Blueprint $table) {
                $table->dropUnique('produks_kode_produk_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('produks', 'kode_produk')) {
            // Re-add unique constraint on kode_produk
            Schema::table('produks', function (Blueprint $table) {
                $table->unique('kode_produk');
            });
        }
    }
};
