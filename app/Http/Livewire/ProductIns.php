<?php

namespace App\Http\Livewire;

use App\Actions\DecreaseQuantityAction;
use App\Models\Branch;
use Livewire\Component;
use App\Models\ProductIn;
use Livewire\WithPagination;

class ProductIns extends Component
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
        $productIns = ProductIn::with('branch', 'products')
                            ->when($this->searchQuery != '', function ($query) {
                                $query->where(function ($query) {
                                    $query->where('notes', 'like', '%' . $this->searchQuery . '%')
                                        ->orWhere('date_received', 'like', '%' . $this->searchQuery . '%');
                                })
                                ->orWhereHas('products', function ($query) {
                                    $query->where('stock_number', 'like', '%' . $this->searchQuery . '%');
                                });
                            })
                            ->when($this->searchBranch != '', function ($query) {
                                $query->where('branch_id', $this->searchBranch);
                            })
                            ->latest()->paginate(5);

        return view('livewire.product-ins', [
            'productIns' => $productIns
        ]);
    }

    public function deleteProductIn($productInId)
    {
        $productIn = ProductIn::find($productInId);

        foreach ($productIn->products as $product) {
            (new DecreaseQuantityAction())->execute(
                $productIn->branch_id, 
                $product->pivot->product_id, 
                $product->pivot->quantity);
        }

        $productIn->delete();

        session()->flash('success', 'Product in deleted successfully!');
    }
}
