<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.produk.kategori', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.produk.kategori_create');
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create($request->all());

        return redirect()->route('kategori.index')->with('success', 'Category created successfully.');
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param  Category  $kategori
     * @return \Illuminate\View\View
     */
    public function edit(Category $kategori)
    {
        return view('admin.produk.edit', compact('kategori'));
    }

    /**
     * Update the specified category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Category  $kategori
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Category $kategori)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $kategori->id,
        ]);

        $kategori->update($request->all());

        return redirect()->route('kategori.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  Category  $kategori
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $kategori)
    {
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Category deleted successfully.');
    }
}
