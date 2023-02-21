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
                <x-input-label for="date_issued" :value="__('Date')"/>
                <x-text-input type="date"
                        wire:model="productOut.date_issued"
                        id="date_issued"
                        name="date_issued"
                        class="block w-full {{ $errors->has('productOut.date_issued') ? 'border-red-500' : '' }}"
                        />
                <x-input-error :messages="$errors->get('productOut.date_issued')" class="mt-2" />
            </div>
            
            <div class="mt-4">
                <x-input-label for="branch_id" :value="__('Branch')"/>

                <x-select wire:model="productOut.branch_id"
                        name="branch_id" 
                        id="branch_id" 
                        class="{{ $errors->has('productOut.branch_id') ? 'border-red-500' : '' }}"
                        >
                        <option value="">-- Select a branch --</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                </x-select>
                <x-input-error :messages="$errors->get('productOut.branch_id')" class="mt-2" />
            </div>
                    
            <div class="mt-4 p-4 bg-gray-50 rounded-lg shadow-xs"> 
                <div class="mt-4">
                    <x-secondary-button wire:click="addProductOut">
                        {{ __('Add row') }}
                    </x-secondary-button>
                </div>
                @foreach ($productOutProducts as $index => $productOutProduct)
                    <div class="flex">
                        <div class="w-1/4 mr-2 w-full">
                            <div class="mt-4">
                                <x-input-label for="product_id_{{ $index }}" :value="__('Product')"/>
                                <x-select name="product_outs[{{ $index }}][product_id]"
                                    wire:model="productOutProducts.{{ $index }}.product_id" 
                                    id="product_id_{{ $index }}" 
                                    class="{{ $errors->has('productOutProducts.' . $index . '.product_id') ? 'border-red-500' : '' }}"
                                    >
                                    <option value="">-- Select a product --</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->detail }}</option>
                                    @endforeach
                                </x-select>
                                <x-input-error :messages="$errors->get('productOutProducts.' . $index . '.product_id')" class="mt-2" />
                            </div>
                        </div>

                        <div class="w-1/4 mr-2 w-full">
                            <div class="mt-4">
                                <x-input-label for="price_{{ $index }}" :value="__('Price')"/>
                                <x-text-input type="number"
                                        name="product_outs[{{ $index }}][price]"
                                        wire:model.defer="productOutProducts.{{ $index }}.price"
                                        id="price_{{ $index }}"
                                        class="block w-full bg-gray-100"
                                        disabled
                                        />
                            </div>
                        </div>

                        <div class="w-1/4 mr-2 w-full">
                            <div class="mt-4">
                                <x-input-label for="quantity_{{ $index }}" :value="__('Quantity')"/>
                                <x-text-input type="number"
                                        name="product_outs[{{ $index }}][quantity]"
                                        wire:model="productOutProducts.{{ $index }}.quantity"
                                        id="quantity_{{ $index }}"
                                        class="block w-full {{ $errors->has('productOutProducts.' . $index . '.quantity') ? 'border-red-500' : '' }}"
                                        min="1"
                                        />
                                <x-input-error :messages="$errors->get('productOutProducts.' . $index . '.quantity')" class="mt-2" />
                            </div>
                        </div>

                        <div class="w-1/4 mr-2 w-full">
                            <div class="mt-4">
                                <x-input-label for="price_sold_{{ $index }}" :value="__('Price sold at')"/>
                                <x-text-input type="number"
                                        name="product_outs[{{ $index }}][price_sold]"
                                        wire:model.defer="productOutProducts.{{ $index }}.price_sold"
                                        id="price_sold_{{ $index }}"
                                        class="block w-full {{ $errors->has('productOutProducts.' . $index . '.price_sold') ? 'border-red-500' : '' }}"
                                        step="any"
                                        />
                                <x-input-error :messages="$errors->get('productOutProducts.' . $index . '.price_sold')" class="mt-2" />
                            </div>
                        </div>

                        <div class="w-1/4 mr-2 w-full">
                            <div class="mt-4 mb-4">
                                <x-danger-button class="mt-7" type="button" wire:click="removeProductOut({{ $index }})">
                                    {{ __('Remove') }}
                                </x-danger-button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                <x-input-label for="notes" :value="__('Notes')"/>
                <x-textarea wire:model="productOut.notes" id="notes" name="notes" class="block w-full">{{ old('notes') }}</x-textarea>
            </div>

            <div class="mt-4">
                <x-primary-button>
                    {{ __('Save') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>