<?php

namespace App\Http\Livewire;

use App\Models\Branch;
use App\Models\Product;
use Livewire\Component;
use App\Models\ProductIn;

class ProductInsForm extends Component
{
    public $products;
    public $branches;
    public $productInProducts = [];
    public ProductIn $productIn;

    public function mount(ProductIn $productIn)
    {
        $this->products = Product::get();
        $this->branches = Branch::get();

        $this->productIn = $productIn;
        
        $this->productIn->date_received = $productIn->date_received?? now()->toDateString();
        
        if ($this->productIn->products->isEmpty()) {
            $this->productInProducts[] = ['product_id' => '', 'quantity' => ''];
        } else {
            foreach ($this->productIn->products as $product) {
                $this->productInProducts[] = [
                    'product_id' => $product->pivot->product_id, 
                    'quantity' => $product->pivot->quantity
                ];
            }
        }
    }

    protected $rules = [
        'productIn.date_received' => ['required', 'date'],
        'productIn.branch_id' => ['required', 'exists:branches,id'],
        'productInProducts.*.product_id' => ['required', 'exists:products,id', 'distinct'],
        'productInProducts.*.quantity' => ['required', 'integer', 'min:1'],
        'productIn.notes' => ['nullable'],
    ];

    protected $messages = [
        'productIn.branch_id.required' => 'The branch field is required.',
        'productInProducts.*.product_id.required' => 'The product field is required.',
        'productInProducts.*.product_id.distinct' => 'The product has been selected more than once.',
        'productInProducts.*.quantity.required' => 'The quantity field is required.',
        'productInProducts.*.quantity.min' => 'The quantity must be at least 1.',
        'productInProducts.*.quantity.integer' => 'The quantity must be a valid number.',
    ];

    public function render()
    {
        return view('livewire.product-ins-form');
    }

    public function addProductIn()
    {
        $this->productInProducts[] = ['product_id' => '', 'quantity' => ''];
    }

    public function removeProductIn($index)
    {
        if ($index == 0 && count($this->productInProducts) == 1) {
            return session()->flash('warning', 'Cannot remove. At least one product is required.');
        }

        unset($this->productInProducts[$index]);

        $this->productInProducts = array_values($this->productInProducts);
    }

    public function save()
    {
        $this->validate();

        $this->productIn->save();

        $products = collect($this->productInProducts)->mapWithKeys(function ($product) {
            return [$product['product_id'] => ['quantity' => $product['quantity']]];
        });

        $this->productIn->products()->sync($products);

        return to_route('product-ins.index')->with('success', 'Product in saved successfully!');
    }
}
