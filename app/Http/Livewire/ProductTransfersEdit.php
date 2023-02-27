<?php

namespace App\Http\Livewire;

use App\Models\Branch;
use App\Models\Product;
use Livewire\Component;
use App\Models\BranchProduct;
use App\Models\ProductTransfer;
use App\Actions\DecreaseQuantityAction;
use App\Actions\IncreaseQuantityAction;

class ProductTransfersEdit extends Component
{
    public $products;
    public $branches;
    public ProductTransfer $productTransfer;
    public $productTransferProducts = [];

    protected $rules = [
        'productTransfer.date_transferred' => ['required', 'date'],
        'productTransfer.sending_branch_id' => ['required', 'exists:branches,id', 'different:productTransfer.receiving_branch_id'],
        'productTransfer.receiving_branch_id' => ['required', 'exists:branches,id', 'different:productTransfer.sending_branch_id'],
        'productTransferProducts.*.product_id' => ['required', 'exists:products,id', 'distinct'],
        'productTransferProducts.*.quantity' => ['required', 'integer'],
        'productTransfer.notes' => ['nullable'],
    ];

    protected $validationAttributes = [
        'productTransfer.sending_branch_id' => 'sending branch',
        'productTransfer.receiving_branch_id' => 'receiving branch',
        'productTransferProducts.*.product_id' => 'product',
        'productTransferProducts.*.quantity' => 'quantity',
    ];

    protected $messages = [
        'productTransferProducts.*.product_id.distinct' => 'The product has been selected more than once.',
    ];

    public function mount(ProductTransfer $productTransfer)
    {
        $this->products = Product::all();
        $this->branches = Branch::all();
        $this->productTransfer = $productTransfer;

        foreach ($this->productTransfer->products as $product) {
            $this->productTransferProducts[] = [
                'product_id' => $product->pivot->product_id,
                'quantity' => $product->pivot->quantity,
            ];
        }
    }
    
    public function render()
    {
        return view('livewire.product-transfers-form');
    }

    public function addProductTransfer()
    {
        $this->productTransferProducts[] = ['product_id' => '', 'quantity' => ''];
    }

    public function removeProductTransfer($index)
    {
        if ($index == 0 && count($this->productTransferProducts) == 1) {
            return session()->flash('warning', 'Cannot remove. At least one product is required.');
        }

        unset($this->productTransferProducts[$index]);

        $this->productTransferProducts = array_values($this->productTransferProducts);

        $this->resetValidation();
    }

    public function addValidationForQuantities()
    {
        foreach ($this->productTransferProducts as $index => $productTransferProduct) {
            $branchId = $this->productTransfer->sending_branch_id;
            $productId = $productTransferProduct['product_id'];

            if ($branchId && $productId) {
                $branchProduct = BranchProduct::query()
                    ->select('quantity')
                    ->where('branch_id', $branchId)
                    ->where('product_id', $productId)
                    ->first();
                    
                if ($branchProduct) {
                    foreach ($this->productTransfer->products as $product) {
                        if ($product->pivot->product_id == $productId) {
                            $this->rules['productTransferProducts.' . $index . '.quantity'] = ['required', 'integer', 'max:' . $branchProduct->quantity + $product->pivot->quantity];
                            $this->messages['productTransferProducts.' . $index . '.quantity.required'] = 'The quantity field is required.';                
                            $this->messages['productTransferProducts.' . $index . '.quantity.max'] = 'The quantity remaining is ' . $branchProduct->quantity + $product->pivot->quantity . '.';
                        } else {
                            $this->rules['productTransferProducts.' . $index . '.quantity'] = ['required', 'integer', 'max:' . $branchProduct->quantity];
                            $this->messages['productTransferProducts.' . $index . '.quantity.required'] = 'The quantity field is required.';                
                            $this->messages['productTransferProducts.' . $index . '.quantity.max'] = 'The quantity remaining is ' . $branchProduct->quantity . '.';
                        }
                    }
                } else {
                    $this->rules['productTransferProducts.' . $index . '.quantity'] = ['required', 'prohibited'];
                    $this->messages['productTransferProducts.' . $index . '.quantity.required'] = 'The quantity field is required.';                
                    $this->messages['productTransferProducts.' . $index . '.quantity.prohibited'] = 'The quantity remaining is 0.';                
                }
            }
        }
    }

    public function save()
    {
        $this->addValidationForQuantities();
        
        $this->validate();

        $originalReceivingBranchId = $this->productTransfer->getOriginal('receiving_branch_id');
        $originalSendingBranchId = $this->productTransfer->getOriginal('sending_branch_id');

        foreach ($this->productTransfer->products as $product) {
            (new DecreaseQuantityAction())->execute(
                $originalReceivingBranchId, 
                $product->pivot->product_id, 
                $product->pivot->quantity);

            (new IncreaseQuantityAction())->execute(
                $originalSendingBranchId, 
                $product->pivot->product_id, 
                $product->pivot->quantity);
        }

        foreach ($this->productTransferProducts as $productTransferProduct) {
            (new DecreaseQuantityAction())->execute(
                $this->productTransfer->sending_branch_id, 
                $productTransferProduct['product_id'], 
                $productTransferProduct['quantity']);
                
            (new IncreaseQuantityAction())->execute(
                $this->productTransfer->receiving_branch_id, 
                $productTransferProduct['product_id'], 
                $productTransferProduct['quantity']);
        }

        $this->productTransfer->save();

        $products = collect($this->productTransferProducts)->mapWithKeys(function ($product) {
            return [
                $product['product_id'] => [
                    'quantity' => $product['quantity'],
                ]
            ];
        });

        $this->productTransfer->products()->sync($products);

        return to_route('product-transfers.index')->with('success', 'Product transfer edited successfully!');
    }
}
