<div>
    @if (session('warning'))
        <div class="inline-flex w-full mb-4 overflow-hidden bg-white rounded-lg shadow-md">
            <div class="flex items-center justify-center w-12 bg-red-500">
                <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                    <path
                            d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z">
                    </path>
                </svg>
            </div>

            <div class="px-4 py-2 -mx-3">
                <div class="mx-3">
                    <span class="font-semibold text-red-500">Warning</span>
                    <p class="text-sm text-gray-600">{{ session('warning') }}</p>
                </div>
            </div>
            
        </div>
    @endif

    <div class="p-4 bg-white rounded-lg shadow-md">
        <form wire:submit.prevent="save" method="POST">
            @csrf

            <div class="mt-4">
                <x-input-label for="date_transferred" :value="__('Date transferred')"/>
                <x-text-input type="date"
                        wire:model="productTransfer.date_transferred"
                        id="date_transferred"
                        name="date_transferred"
                        class="block w-full {{ $errors->has('productTransfer.date_transferred') ? 'border-red-500' : '' }}"
                        />
                <x-input-error :messages="$errors->get('productTransfer.date_transferred')" class="mt-2" />
            </div>
            
            <div class="mt-4">
                <x-input-label for="sending_branch_id" :value="__('Sending branch')"/>

                <x-select wire:model="productTransfer.sending_branch_id"
                        name="sending_branch_id" 
                        id="sending_branch_id" 
                        class="{{ $errors->has('productTransfer.sending_branch_id') ? 'border-red-500' : '' }}"
                        >
                        <option value="">-- Select a branch --</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                </x-select>
                <x-input-error :messages="$errors->get('productTransfer.sending_branch_id')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="receiving_branch_id" :value="__('Receiving branch')"/>

                <x-select wire:model="productTransfer.receiving_branch_id"
                        name="receiving_branch_id" 
                        id="receiving_branch_id" 
                        class="{{ $errors->has('productTransfer.receiving_branch_id') ? 'border-red-500' : '' }}"
                        >
                        <option value="">-- Select a branch --</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                </x-select>
                <x-input-error :messages="$errors->get('productTransfer.receiving_branch_id')" class="mt-2" />
            </div>
                    
            <div class="mt-4 p-4 bg-gray-50 rounded-lg shadow-xs"> 
                <div class="mt-4">
                    <x-secondary-button wire:click="addProductTransfer">
                        {{ __('Add row') }}
                    </x-secondary-button>
                </div>
                @foreach ($productTransferProducts as $index => $productTransferProduct)
                    <div class="flex">
                        <div class="w-1/4 mr-2 w-full">
                            <div class="mt-4">
                                <x-input-label for="product_id_{{ $index }}" :value="__('Product')"/>
                                <x-select name="product_transfers[{{ $index }}][product_id]"
                                    wire:model="productTransferProducts.{{ $index }}.product_id" 
                                    id="product_id_{{ $index }}" 
                                    class="{{ $errors->has('productTransferProducts.' . $index . '.product_id') ? 'border-red-500' : '' }}"
                                    >
                                    <option value="">-- Select a product --</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->detail }}</option>
                                    @endforeach
                                </x-select>
                                <x-input-error :messages="$errors->get('productTransferProducts.' . $index . '.product_id')" class="mt-2" />
                            </div>
                        </div>

                        <div class="w-1/4 mr-2 w-full">
                            <div class="mt-4">
                                <x-input-label for="quantity_{{ $index }}" :value="__('Quantity')"/>
                                <x-text-input type="number"
                                        name="product_transfers[{{ $index }}][quantity]"
                                        wire:model="productTransferProducts.{{ $index }}.quantity"
                                        id="quantity_{{ $index }}"
                                        class="block w-full {{ $errors->has('productTransferProducts.' . $index . '.quantity') ? 'border-red-500' : '' }}"
                                        min="1"
                                        />
                                <x-input-error :messages="$errors->get('productTransferProducts.' . $index . '.quantity')" class="mt-2" />
                            </div>
                        </div>

                        <div class="w-1/4 mr-2 w-full">
                            <div class="mt-4 mb-4">
                                <x-danger-button class="mt-7" type="button" wire:click="removeProductTransfer({{ $index }})">
                                    {{ __('Remove') }}
                                </x-danger-button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                <x-input-label for="notes" :value="__('Notes')"/>
                <x-textarea wire:model="productTransfer.notes" id="notes" name="notes" class="block w-full"></x-textarea>
            </div>

            <div class="mt-4">
                <x-primary-button>
                    {{ __('Save') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>