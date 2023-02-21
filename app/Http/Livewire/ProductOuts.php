<?php

namespace App\Http\Livewire;

use App\Models\Branch;
use Livewire\Component;
use App\Models\ProductOut;
use Livewire\WithPagination;
use App\Actions\IncreaseQuantityAction;

class ProductOuts extends Component
{
    use WithPagination;
    
    public $searchQuery;
    public $searchBranch;
    public $branches;

    public function mount()
    {
        $this->searchQuery = '';
        $this->searchBranch = '';
        $this->branches = Branch::all();
    }

    public function render()
    {
        $productOuts = ProductOut::with('branch', 'products')
                            ->when($this->searchQuery != '', function ($query) {
                                $query->where(function ($query) {
                                    $query->where('notes', 'like', '%' . $this->searchQuery . '%')
                                        ->orWhere('date_issued', 'like', '%' . $this->searchQuery . '%');
                                })
                                ->orWhereHas('products', function ($query) {
                                    $query->where('stock_number', 'like', '%' . $this->searchQuery . '%');
                                });
                            })
                            ->when($this->searchBranch != '', function ($query) {
                                $query->where('branch_id', $this->searchBranch);
                            })
                            ->latest()->paginate(5);

        return view('livewire.product-outs', [
            'productOuts' => $productOuts
        ]);
    }

    public function deleteProductOut($productOutId)
    {
        $productOut = ProductOut::find($productOutId);
        
        foreach ($productOut->products as $product) {
            (new IncreaseQuantityAction())->execute(
                $productOut->branch_id, 
                $product->pivot->product_id, 
                $product->pivot->quantity);
        }

        $productOut->delete();

        session()->flash('success', 'Product out deleted successfully!');
    }
}
