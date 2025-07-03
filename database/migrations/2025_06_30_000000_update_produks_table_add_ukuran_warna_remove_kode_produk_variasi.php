<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            if (Schema::hasColumn('produks', 'kode_produk')) {
                $table->dropColumn('kode_produk');
            }
            if (Schema::hasColumn('produks', 'variasi')) {
                $table->dropColumn('variasi');
            }
            if (!Schema::hasColumn('produks', 'ukuran')) {
                $table->string('ukuran')->nullable()->after('harga');
            }
            if (!Schema::hasColumn('produks', 'warna')) {
                $table->string('warna')->nullable()->after('ukuran');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            if (!Schema::hasColumn('produks', 'kode_produk')) {
                $table->string('kode_produk')->unique()->after('id');
            }
            if (!Schema::hasColumn('produks', 'variasi')) {
                $table->string('variasi')->nullable()->after('harga');
            }
            if (Schema::hasColumn('produks', 'ukuran')) {
                $table->dropColumn('ukuran');
            }
            if (Schema::hasColumn('produks', 'warna')) {
                $table->dropColumn('warna');
            }
        });
    }
};
