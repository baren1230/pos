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
        if (!Schema::hasColumn('produks', 'supplier_id')) {
            Schema::table('produks', function (Blueprint $table) {
                $table->unsignedBigInteger('supplier_id')->nullable()->after('kategori_id');
                $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('produks', 'supplier_id')) {
            Schema::table('produks', function (Blueprint $table) {
                $table->dropForeign(['supplier_id']);
                $table->dropColumn('supplier_id');
            });
        }
    }
};
