<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::latest()->paginate();

        return view('products.index', compact('products'));
    }

    public function create(): View
    {
        return view('products.create');
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        Product::create($request->validated());

        return to_route('products.index')->with('success', 'Product created successfully!');
    }

    public function show($id): View
    {
        return view('.show', compact(''));
    }

    public function edit(Product $product): View
    {
        return view('products.edit', compact('product'));
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->validated());

        return to_route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return to_route('products.index')->with('success', 'Product deleted successfully!');
    }
}
