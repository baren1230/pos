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
            if (!Schema::hasColumn('produks', 'harga_beli')) {
                $table->decimal('harga_beli', 15, 2)->after('deskripsi');
            }
            if (!Schema::hasColumn('produks', 'variasi')) {
                $table->string('variasi')->nullable()->after('harga');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            if (Schema::hasColumn('produks', 'harga_beli')) {
                $table->dropColumn('harga_beli');
            }
            if (Schema::hasColumn('produks', 'variasi')) {
                $table->dropColumn('variasi');
            }
        });
    }
};
