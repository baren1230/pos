<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
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

    public function test_index_displays_categories()
    {
        $response = $this->get(route('kategori.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.produk.kategori');
    }

    public function test_create_displays_form()
    {
        $response = $this->get(route('kategori.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.produk.kategori_create');
    }

    public function test_store_creates_new_category()
    {
        $data = [
            'name' => 'Test Category',
        ];

        $response = $this->post(route('kategori.store'), $data);

        $response->assertRedirect(route('kategori.index'));
        $this->assertDatabaseHas('categories', ['name' => 'Test Category']);
    }

    public function test_edit_displays_form()
    {
        $category = Category::factory()->create();

        $response = $this->get(route('kategori.edit', $category));
        $response->assertStatus(200);
        $response->assertViewIs('admin.produk.edit');
    }

    public function test_update_modifies_category()
    {
        $category = Category::factory()->create();

        $data = [
            'name' => 'Updated Category',
        ];

        $response = $this->put(route('kategori.update', $category), $data);

        $response->assertRedirect(route('kategori.index'));
        $this->assertDatabaseHas('categories', ['name' => 'Updated Category']);
    }

    public function test_destroy_deletes_category()
    {
        $category = Category::factory()->create();

        $response = $this->delete(route('kategori.destroy', $category));

        $response->assertRedirect(route('kategori.index'));
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
