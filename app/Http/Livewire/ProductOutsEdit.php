<?php

namespace App\Http\Livewire;

use App\Models\Branch;
use App\Models\Product;
use Livewire\Component;
use App\Models\ProductOut;
use App\Actions\DecreaseQuantityAction;
use App\Actions\IncreaseQuantityAction;
use App\Models\BranchProduct;

class ProductOutsEdit extends Component
{
    public $products;
    public $branches;
    public $productOutProducts = [];
    public ProductOut $productOut;

    protected $rules = [
        'productOut.date_issued' => ['required', 'date'],
        'productOut.branch_id' => ['required', 'exists:branches,id'],
        'productOutProducts.*.product_id' => ['required', 'exists:products,id', 'distinct'],
        'productOutProducts.*.price_sold' => ['required', 'numeric'],
        'productOutProducts.*.quantity' => ['required', 'integer'],
        'productOut.notes' => ['nullable'],
    ];

    protected $validationAttributes = [
        'productOut.branch_id' => 'branch',
        'productOutProducts.*.product_id' => 'product',
        'productOutProducts.*.quantity' => 'quantity',
        'productOutProducts.*.price_sold' => 'price sold',
    ];

    protected $messages = [
        'productOutProducts.*.product_id.distinct' => 'The product has been selected more than once.',
    ];

    public function mount(ProductOut $productOut)
    {
        $this->products = Product::all();
        $this->branches = Branch::all();
        $this->productOut = $productOut;

        foreach ($this->productOut->products as $product) {
            $this->productOutProducts[] = [
                'product_id' => $product->pivot->product_id,
                'price' => $product->price,
                'quantity' => $product->pivot->quantity,
                'price_sold' => $product->pivot->price_sold,
            ];
        }
    }

    public function render()
    {
        return view('livewire.product-outs-form');
    }

    public function addProductOut()
    {
        $this->productOutProducts[] = ['product_id' => '', 'quantity' => '', 'price' => ''];
    }

    public function removeProductOut($index)
    {
        if ($index == 0 && count($this->productOutProducts) == 1) {
            return session()->flash('warning', 'Cannot remove. At least one product is required.');
        }

        unset($this->productOutProducts[$index]);

        $this->productOutProducts = array_values($this->productOutProducts);

        $this->resetValidation();
    }

    public function addValidationForQuantities()
    {
        foreach ($this->productOutProducts as $index => $productOutProduct) {
            $branchId = $this->productOut->branch_id;
            $productId = $productOutProduct['product_id'];

            if ($branchId && $productId) {
                $branchProduct = BranchProduct::query()
                    ->select('quantity')
                    ->where('branch_id', $branchId)
                    ->where('product_id', $productId)
                    ->first();
                    
                if ($branchProduct) {
                    foreach ($this->productOut->products as $product) {
                        if ($product->pivot->product_id == $productId) {
                            $this->rules['productOutProducts.' . $index . '.quantity'] = ['required', 'integer', 'max:' . $branchProduct->quantity + $product->pivot->quantity];
                            $this->messages['productOutProducts.' . $index . '.quantity.required'] = 'The quantity field is required.';                
                            $this->messages['productOutProducts.' . $index . '.quantity.max'] = 'The quantity remaining is ' . $branchProduct->quantity + $product->pivot->quantity . '.';
                        } else {
                            $this->rules['productOutProducts.' . $index . '.quantity'] = ['required', 'integer', 'max:' . $branchProduct->quantity];
                            $this->messages['productOutProducts.' . $index . '.quantity.required'] = 'The quantity field is required.';                
                            $this->messages['productOutProducts.' . $index . '.quantity.max'] = 'The quantity remaining is ' . $branchProduct->quantity . '.';
                        }
                    }
                } else {
                    $this->rules['productOutProducts.' . $index . '.quantity'] = ['required', 'prohibited'];
                    $this->messages['productOutProducts.' . $index . '.quantity.required'] = 'The quantity field is required.';                
                    $this->messages['productOutProducts.' . $index . '.quantity.prohibited'] = 'The quantity remaining is 0.';                
                }
            }
        }
    }
    
    public function updatedProductOutProducts($value, $row)
    {
        $parts = explode('.', $row);
        $index = $parts[0];
        $type = $parts[1];

        if ($type == 'product_id') {
            $product = $this->products->where('id', $value)->first();
            
            $this->productOutProducts[$index]['price'] = $product->price?? '';
            $this->productOutProducts[$index]['price_sold'] = $product->price?? '';
            $this->productOutProducts[$index]['product_id'] = $value;
        }
    }

    public function save()
    {
        $this->addValidationForQuantities();
        
        $this->validate();

        $this->productOut->save();

        $products = collect($this->productOutProducts)->mapWithKeys(function ($product) {
            return [
                $product['product_id'] => [
                    'branch_id' => $this->productOut->branch_id,
                    'quantity' => $product['quantity'],
                    'price_sold' => $product['price_sold'],
                ]
            ];
        });

        $this->productOut->products()->sync($products);

        foreach ($this->productOut->products as $product) {
            (new IncreaseQuantityAction())->execute(
                $this->productOut->branch_id, 
                $product->pivot->product_id, 
                $product->pivot->quantity);
        }

        foreach ($this->productOutProducts as $productOutProduct) {
            (new DecreaseQuantityAction())->execute(
                $this->productOut->branch_id, 
                $productOutProduct['product_id'], 
                $productOutProduct['quantity']);
        }

        return to_route('product-outs.index')->with('success', 'Product out edited successfully!');
    }
}
