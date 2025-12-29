<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Promo;
use App\Models\Category;

class AdminController extends Controller
{
    public function __construct()
    {
        // Middleware diterapkan di routes/web.php
    }

    public function dashboard()
    {
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status','pending')->count();
        $totalRevenue = Order::where('status','completed')->sum('total');
        $totalProducts = Product::count();

        $recentOrders = Order::latest()->limit(5)->get();
        $topProducts = Product::withCount(['orderItems as total_sold' => function($q){ $q->selectRaw('coalesce(sum(qty),0)'); }])->orderByDesc('total_sold')->limit(5)->get();

        $promos = Promo::latest()->limit(5)->get();

        return view('admin.dashboard', compact('totalOrders','pendingOrders','totalRevenue','totalProducts','recentOrders','topProducts','promos'));
    }

    // Orders
    public function orders(Request $request)
    {
        $categories = Category::all();

        $query = Order::with('items.product.category','user');

        if ($request->filled('category')) {
            $catId = $request->category;
            $query->whereHas('items.product', function($q) use ($catId) {
                $q->where('category_id', $catId);
            });
        }

        $orders = $query->latest()->paginate(20)->withQueryString();

        return view('admin.orders.index', compact('orders','categories'));
    }

    public function orderDetail($id)
    {
        $order = Order::with('items.product','user')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status'=>'required|string']);
        $order = Order::findOrFail($id);
        $order->status = $request->input('status');
        $order->save();
        return redirect()->back()->with('success','Status pesanan diperbarui');
    }

    // Products
    public function products(Request $request)
    {
        $categories = Category::all();

        $query = Product::query();

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->latest()->paginate(20)->withQueryString();

        return view('admin.products.index', compact('products','categories'));
    }

    public function createProduct()
    {
        $categories = Category::all();
        return view('admin.products.form', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string',
            'price'=>'required|numeric',
            'stock'=>'required|integer',
            'description'=>'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file->getClientOriginalName());
            $file->move(public_path('assets/img'), $filename);
            $data['image'] = 'assets/img/' . $filename;
        }

        Product::create($data);
        return redirect()->route('admin.products')->with('success','Produk dibuat');
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.form', compact('product','categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $data = $request->validate([
            'name'=>'required|string',
            'price'=>'required|numeric',
            'stock'=>'required|integer',
            'description'=>'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('image')) {
            // delete old image if exists
            if ($product->image && file_exists(public_path($product->image))) {
                @unlink(public_path($product->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file->getClientOriginalName());
            $file->move(public_path('assets/img'), $filename);
            $data['image'] = 'assets/img/' . $filename;
        }

        $product->update($data);
        return redirect()->route('admin.products')->with('success','Produk diperbarui');
    }

    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products')->with('success','Produk dihapus');
    }

    // Promos
    public function promos()
    {
        $promos = Promo::latest()->paginate(20);
        return view('admin.promos.index', compact('promos'));
    }

    public function createPromo()
    {
        return view('admin.promos.form');
    }

    public function storePromo(Request $request)
    {
        $data = $request->validate([
            'code'=>'required|string|unique:promos,code',
            'type'=>'required|in:percent,fixed',
            'value'=>'required|numeric',
            'starts_at'=>'nullable|date',
            'ends_at'=>'nullable|date',
            'active'=>'nullable|boolean',
        ]);
        $data['active'] = $request->has('active');
        Promo::create($data);
        return redirect()->route('admin.promos')->with('success','Promo dibuat');
    }

    public function editPromo($id)
    {
        $promo = Promo::findOrFail($id);
        return view('admin.promos.form', compact('promo'));
    }

    public function updatePromo(Request $request, $id)
    {
        $promo = Promo::findOrFail($id);
        $data = $request->validate([
            'code'=>'required|string|unique:promos,code,'.$promo->id,
            'type'=>'required|in:percent,fixed',
            'value'=>'required|numeric',
            'starts_at'=>'nullable|date',
            'ends_at'=>'nullable|date',
            'active'=>'nullable|boolean',
        ]);
        $data['active'] = $request->has('active');
        $promo->update($data);
        return redirect()->route('admin.promos')->with('success','Promo diperbarui');
    }

    public function destroyPromo($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->delete();
        return redirect()->route('admin.promos')->with('success','Promo dihapus');
    }

    // Analytics
    public function analytics()
    {
        $salesByDay = Order::selectRaw('DATE(created_at) as day, sum(total) as total')
            ->where('status','completed')
            ->groupBy('day')
            ->orderBy('day','desc')
            ->limit(30)
            ->get();

        return view('admin.analytics', compact('salesByDay'));
    }
}

