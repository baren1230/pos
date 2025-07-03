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
            if (Schema::hasColumn('produks', 'kategori')) {
                $table->renameColumn('kategori', 'kategori_id');
            }
        });

        Schema::table('produks', function (Blueprint $table) {
            if (!Schema::hasColumn('produks', 'kategori_id')) {
                $table->unsignedBigInteger('kategori_id')->nullable()->after('nama_produk');
            }
        });

        Schema::table('produks', function (Blueprint $table) {
            if (Schema::hasColumn('produks', 'kategori_id')) {
                $table->unsignedBigInteger('kategori_id')->nullable()->change();
                $table->foreign('kategori_id')->references('id')->on('categories')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            if (Schema::hasColumn('produks', 'kategori_id')) {
                $table->dropForeign(['kategori_id']);
                $table->renameColumn('kategori_id', 'kategori');
            }
        });

        Schema::table('produks', function (Blueprint $table) {
            if (!Schema::hasColumn('produks', 'kategori')) {
                $table->string('kategori')->nullable()->after('nama_produk');
            }
        });
    }
};
