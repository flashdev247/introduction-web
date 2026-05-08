<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.index', ['products' => Product::with('category')->latest()->get()]);
    }

    public function create()
    {
        return view('admin.products.form', ['product' => new Product(), 'categories' => Category::orderBy('name')->get()]);
    }

    public function store(Request $request)
    {
        Product::create($this->validated($request));
        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.form', ['product' => $product, 'categories' => Category::orderBy('name')->get()]);
    }

    public function update(Request $request, Product $product)
    {
        $product->update($this->validated($request));
        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'sku' => ['nullable', 'string', 'max:255'],
            'price' => ['nullable', 'numeric'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'images_text' => ['nullable', 'string'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['images'] = collect(preg_split('/\r\n|\r|\n/', $data['images_text'] ?? ''))->filter()->values()->all();
        unset($data['images_text']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
