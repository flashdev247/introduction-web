<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\ContactSetting;
use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $settings = ContactSetting::first();
        $featuredProducts = Product::where('is_active', true)->where('is_featured', true)->take(6)->get();

        return view('front.home', compact('settings', 'featuredProducts'));
    }

    public function products()
    {
        $settings = ContactSetting::first();
        $products = Product::with('category')->where('is_active', true)->latest()->get();
        $categories = Category::all();
        $currentCategory = null;

        return view('front.products', compact('settings', 'products', 'categories', 'currentCategory'));
    }

    public function productsCategoryOrDetail(string $slug)
    {
        $settings = ContactSetting::first();

        // Check if slug matches a category
        $category = Category::where('slug', $slug)->first();
        if ($category) {
            $products = Product::with('category')->where('is_active', true)->where('category_id', $category->id)->latest()->get();
            $categories = Category::all();
            $currentCategory = $category;
            return view('front.products', compact('settings', 'products', 'categories', 'currentCategory'));
        }

        // Otherwise treat as product slug
        $product = Product::with('category')->where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('front.product-detail', compact('settings', 'product'));
    }

    public function productsByCategory(string $category)
    {
        return redirect()->route('products.show', ['slug' => $category], 301);
    }

    public function productDetail(string $slug)
    {
        $settings = ContactSetting::first();
        $product = Product::with('category')->where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('front.product-detail', compact('settings', 'product'));
    }

    public function contact()
    {
        $settings = ContactSetting::first();

        return view('front.contact', compact('settings'));
    }

    public function submitContact(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        ContactMessage::create($data);

        return back()->with('success', 'Thank you. Your message has been sent.');
    }
}
