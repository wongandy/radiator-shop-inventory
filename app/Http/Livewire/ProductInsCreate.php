<?php

namespace App\Http\Livewire;

use App\Models\Branch;
use App\Models\Product;
use Livewire\Component;
use App\Models\ProductIn;
use App\Actions\IncreaseQuantityAction;
use App\Http\Requests\ProductInRequest;

class ProductInsCreate extends Component
{
    public $products;
    public $branches;
    public $productInProducts = [];
    public ProductIn $productIn;

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

    public function mount(ProductIn $productIn)
    {
        $this->products = Product::all();
        $this->branches = Branch::all();

        $this->productIn = $productIn;
        
        $this->productIn->date_received = now()->toDateString();
        
        $this->productInProducts[] = ['product_id' => '', 'quantity' => ''];
    }

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

        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        $this->productIn->save();
        
        $products = collect($this->productInProducts)->mapWithKeys(function ($product) {
            return [$product['product_id'] => ['quantity' => $product['quantity']]];
        });
        
        $this->productIn->products()->sync($products);
        
        foreach ($this->productInProducts as $productInProduct) {            
            (new IncreaseQuantityAction())->execute(
                $this->productIn->branch_id, 
                $productInProduct['product_id'], 
                $productInProduct['quantity']);
        }
        
        return to_route('product-ins.index')->with('success', 'Product in created successfully!');
    }
}
