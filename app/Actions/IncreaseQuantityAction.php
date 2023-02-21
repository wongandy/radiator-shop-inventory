<?php

namespace App\Actions;

use App\Models\BranchProduct;
use Illuminate\Support\Facades\DB;

class IncreaseQuantityAction {
    public function execute(int $branchId, int $productId, int $quantity): void
    {
        $branchProduct = BranchProduct::firstOrNew([
            'branch_id' => $branchId,
            'product_id' => $productId,
        ]);

        $branchProduct->quantity += $quantity;
        $branchProduct->save();
    }
}