<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelianItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembelian_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pembelian_id');
            $table->unsignedBigInteger('produk_id');
            $table->integer('quantity');
            $table->decimal('price', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();

            $table->foreign('pembelian_id')->references('id')->on('pembelians')->onDelete('cascade');
            $table->foreign('produk_id')->references('id')->on('produks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_items');
    }
}