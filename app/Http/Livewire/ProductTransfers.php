<?php

namespace App\Http\Livewire;

use App\Models\Branch;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ProductTransfer;
use App\Actions\DecreaseQuantityAction;
use App\Actions\IncreaseQuantityAction;

class ProductTransfers extends Component
{
    use WithPagination;
    
    public $searchQuery;
    public $branches;

    public function mount()
    {
        $this->searchQuery = '';
        $this->branches = Branch::all();
    }

    public function render()
    {
        $productTransfers = ProductTransfer::with('sendingBranch', 'receivingBranch', 'products')
                                ->when($this->searchQuery != '', function ($query) {
                                    $query->where(function ($query) {
                                        $query->where('notes', 'like', '%' . $this->searchQuery . '%')
                                            ->orWhere('date_transferred', 'like', '%' . $this->searchQuery . '%');
                                    })
                                    ->orWhereHas('products', function ($query) {
                                        $query->where('stock_number', 'like', '%' . $this->searchQuery . '%');
                                    });
                                })
                                ->latest()->paginate(5);

        return view('livewire.product-transfers', [
            'productTransfers' => $productTransfers,
        ]);
    }

    public function deleteProductTransfer($productTransferId)
    {
        $productTransfer = ProductTransfer::find($productTransferId);

        foreach ($productTransfer->products as $product) {
            (new DecreaseQuantityAction())->execute(
                $productTransfer->receiving_branch_id, 
                $product->pivot->product_id, 
                $product->pivot->quantity);

            (new IncreaseQuantityAction())->execute(
                $productTransfer->sending_branch_id, 
                $product->pivot->product_id, 
                $product->pivot->quantity);
        }

        $productTransfer->delete();

        session()->flash('success', 'Product transfer deleted successfully!');
    }
}
