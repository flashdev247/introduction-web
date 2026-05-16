<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class PageController extends Controller
{
    private function getSettings()
    {
        return (object) [
            'site_name' => Setting::get('site_name', 'HTTM VIETNAM'),
            'logo' => Setting::get('logo', ''),
            'email' => Setting::get('email', ''),
            'phone' => Setting::get('phone', ''),
            'zalo' => Setting::get('zalo', ''),
            'shopee' => Setting::get('shopee', ''),
            'address' => Setting::get('address', ''),
            'contact_info' => Setting::get('contact_info', ''),
        ];
    }

    public function home()
    {
        $settings = $this->getSettings();
        $featuredProducts = Product::where('is_active', true)->where('is_featured', true)->latest()->simplePaginate(6);

        return view('front.home', compact('settings', 'featuredProducts'));
    }

    public function products(Request $request)
    {
        $settings = $this->getSettings();
        $categoryId = $request->query('category');
        $search = trim((string) $request->query('q', ''));
        $query = Product::with('category')->latest();

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($search !== '') {
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%');
            });
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::all();
        $currentCategory = null;

        if ($categoryId) {
            $currentCategory = Category::find($categoryId);
        }

        return view('front.products', compact('settings', 'products', 'categories', 'currentCategory', 'search'));
    }

    // removed combined slug handler; categories are filtered via query params

    public function productsByCategory(string $category)
    {
        return redirect()->route('products.index', ['category' => $category], 301);
    }

    public function productDetail(int $id)
    {
        $settings = $this->getSettings();
        $product = Product::with('category')->where('id', $id)->firstOrFail();

        return view('front.product-detail', compact('settings', 'product'));
    }

    public function contact()
    {
        $settings = $this->getSettings();

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
