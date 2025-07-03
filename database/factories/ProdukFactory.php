<?php

namespace Database\Factories;

use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdukFactory extends Factory
{
    protected $model = Produk::class;

    public function definition()
    {
        return [
            'nama_produk' => $this->faker->word(),
            'kategori_id' => null,
            'supplier_id' => null,
            'deskripsi' => $this->faker->sentence(),
            'harga_beli' => $this->faker->randomFloat(2, 1000, 10000),
            'harga' => $this->faker->randomFloat(2, 1000, 15000),
            'stok' => $this->faker->numberBetween(1, 100),
        ];
    }
}