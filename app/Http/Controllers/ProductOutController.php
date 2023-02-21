<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProductOut;
use Illuminate\View\View;

class ProductOutController extends Controller
{
    public function index(): View
    {
        return view('product-outs.index');
    }

    public function create(): View
    {
        return view('product-outs.create');
    }

    public function edit(ProductOut $productOut): View
    {
        return view('product-outs.edit', compact('productOut'));
    }
}
