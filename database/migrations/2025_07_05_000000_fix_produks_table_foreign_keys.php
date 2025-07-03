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
            // Drop foreign key and column suplayer_id if exists
            if (Schema::hasColumn('produks', 'suplayer_id')) {
                try {
                    $table->dropForeign(['suplayer_id']);
                } catch (\Exception $e) {
                    // Foreign key does not exist, ignore
                }
                $table->dropColumn('suplayer_id');
            }
            // Ensure supplier_id column exists and foreign key is set
            if (!Schema::hasColumn('produks', 'supplier_id')) {
                $table->unsignedBigInteger('supplier_id')->nullable()->after('kategori_id');
            }
            // Drop foreign key if exists to avoid duplicate constraint error
            try {
                $table->dropForeign(['supplier_id']);
            } catch (\Exception $e) {
                // Foreign key does not exist, ignore
            }
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            if (Schema::hasColumn('produks', 'supplier_id')) {
                $table->dropForeign(['supplier_id']);
                $table->dropColumn('supplier_id');
            }
            if (!Schema::hasColumn('produks', 'suplayer_id')) {
                $table->unsignedBigInteger('suplayer_id')->nullable()->after('kategori_id');
                $table->foreign('suplayer_id')->references('id')->on('suppliers')->onDelete('set null');
            }
        });
    }
};
