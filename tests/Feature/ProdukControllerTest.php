<?php

namespace Tests\Feature;

use App\Models\Produk;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProdukControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Create a user and authenticate for protected routes if needed
        $this->user = User::factory()->create([
            'role' => 'admin',
        ]);
        $this->actingAs($this->user);
    }

    public function test_index_displays_products()
    {
        $response = $this->get(route('produk.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.produk.index');
    }

    public function test_create_displays_form()
    {
        $response = $this->get(route('produk.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.produk.create');
    }

    public function test_store_creates_new_produk()
    {
        $category = Category::factory()->create();
        $supplier = Supplier::factory()->create();

        $data = [
            'nama_produk' => 'Test Product',
            'kategori_id' => $category->id,
            'supplier_id' => $supplier->id,
            'deskripsi' => 'Test description',
            'harga_beli' => 10000,
            'harga' => 15000,
            'stok' => 10,
        ];

        $response = $this->post(route('produk.store'), $data);

        $response->assertRedirect(route('produk.index'));
        $this->assertDatabaseHas('produks', ['nama_produk' => 'Test Product']);
    }

    public function test_edit_displays_form()
    {
        $produk = Produk::factory()->create();

        $response = $this->get(route('produk.edit', $produk));
        $response->assertStatus(200);
        $response->assertViewIs('admin.produk.produk_edit');
    }

    public function test_update_modifies_produk()
    {
        $produk = Produk::factory()->create();

        $data = [
            'nama_produk' => 'Updated Product',
            'kategori_id' => null,
            'supplier_id' => null,
            'deskripsi' => 'Updated description',
            'harga_beli' => 20000,
            'harga' => 25000,
            'stok' => 5,
        ];

        $response = $this->put(route('produk.update', $produk), $data);

        $response->assertRedirect(route('produk.index'));
        $this->assertDatabaseHas('produks', ['nama_produk' => 'Updated Product']);
    }

    public function test_destroy_deletes_produk()
    {
        $produk = Produk::factory()->create();

        $response = $this->delete(route('produk.destroy', $produk));

        $response->assertRedirect(route('produk.index'));
        $this->assertDatabaseMissing('produks', ['id' => $produk->id]);
    }

    public function test_show_displays_produk()
    {
        $produk = Produk::factory()->create();

        $response = $this->get(route('produk.show', $produk));
        $response->assertStatus(200);
        $response->assertViewIs('admin.produk.show');
    }
}