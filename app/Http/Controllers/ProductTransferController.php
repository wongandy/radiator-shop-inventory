<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProductTransfer;
use Illuminate\View\View;

class ProductTransferController extends Controller
{
    public function index(): View
    {
        return view('product-transfers.index');
    }

    public function create(): View
    {
        return view('product-transfers.create');
    }

    public function edit(ProductTransfer $productTransfer): View
    {
        return view('product-transfers.edit', compact('productTransfer'));
    }
}
