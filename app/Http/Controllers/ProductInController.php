<?php

namespace App\Http\Controllers;

use App\Models\ProductIn;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductInRequest;
use Illuminate\Http\RedirectResponse;
use App\Models\Branch;
use App\Models\Product;

class ProductInController extends Controller
{
    public function index(): View
    {
        return view('product-ins.index');
    }

    public function create(): View
    {
        return view('product-ins.create');
    }

    public function show($id): View
    {
        return view('.show', compact(''));
    }

    public function edit(ProductIn $productIn): View
    {
        return view('product-ins.edit', compact('productIn'));
    }

    public function destroy($id): RedirectResponse
    {
        return to_route('.index');
    }
}
