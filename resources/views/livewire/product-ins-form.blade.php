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
        <form action="{{ route('product-ins.store') }}" wire:submit.prevent="save" method="POST">
            @csrf

            <div class="mt-4">
                <x-input-label for="date_received" :value="__('Date')"/>
                <x-text-input type="date"
                        wire:model="productIn.date_received"
                        id="date_received"
                        name="date_received"
                        class="block w-full {{ $errors->has('productIn.date_received') ? 'border-red-500' : '' }}"
                        value="{{ now()->toDateString() }}"
                        />
                <x-input-error :messages="$errors->get('productIn.date_received')" class="mt-2" />
            </div>
            
            <div class="mt-4">
                <x-input-label for="branch_id" :value="__('Branch')"/>

                <x-select wire:model="productIn.branch_id"
                        name="branch_id" 
                        id="branch_id" 
                        class="{{ $errors->has('productIn.branch_id') ? 'border-red-500' : '' }}"
                        >
                        <option value="">-- Select a branch --</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" @selected(old('branch_id') == $branch->id)>{{ $branch->name }}</option>
                    @endforeach
                </x-select>
                <x-input-error :messages="$errors->get('productIn.branch_id')" class="mt-2" />
            </div>
                    
            <div class="mt-4 p-4 bg-gray-50 rounded-lg shadow-xs"> 
                <div class="mt-4">
                    <x-secondary-button wire:click="addProductIn" id="add-product-in-btn">
                        {{ __('Add row') }}
                    </x-secondary-button>
                </div>
                @foreach ($productInProducts as $index => $productInProduct)
                    <div class="flex">
                        <div class="w-1/3 mr-2 w-full">
                            <div class="mt-4">
                                <x-input-label for="product_id_{{ $index }}" :value="__('Product')"/>
                                <x-select name="product_ins[{{ $index }}][product_id]"
                                    wire:model="productInProducts.{{ $index }}.product_id" 
                                    id="product_id_{{ $index }}" 
                                    class="{{ $errors->has('productInProducts.' . $index . '.product_id') ? 'border-red-500' : '' }}"
                                    >
                                    <option value="">-- Select a product --</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" @selected(old('product_id[]') == $product->detail)>{{ $product->detail }}</option>
                                    @endforeach
                                </x-select>
                                <x-input-error :messages="$errors->get('productInProducts.' . $index . '.product_id')" class="mt-2" />
                            </div>
                        </div>

                        <div class="w-1/3 ml-2 w-full">
                            <div class="mt-4">
                                <x-input-label for="quantity_{{ $index }}" :value="__('Quantity')"/>
                                <x-text-input type="number"
                                        name="product_ins[{{ $index }}][quantity]"
                                        wire:model.defer="productInProducts.{{ $index }}.quantity"
                                        id="quantity_{{ $index }}"
                                        class="block w-full {{ $errors->has('productInProducts.' . $index . '.quantity') ? 'border-red-500' : '' }}"
                                        value="{{ old('quantity[]') }}"
                                        />
                                <x-input-error :messages="$errors->get('productInProducts.' . $index . '.quantity')" class="mt-2" />
                            </div>
                        </div>

                        <div class="w-1/3 ml-2 w-full">
                            <div class="mt-4 mb-4">
                                    <x-danger-button class="mt-7" type="button" wire:click="removeProductIn({{ $index }})">
                                        {{ __('Remove') }}
                                    </x-danger-button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                <x-input-label for="notes" :value="__('Notes')"/>
                <x-textarea wire:model="productIn.notes" id="notes" name="notes" class="block w-full">{{ old('notes') }}</x-textarea>
            </div>

            <div class="mt-4">
                <x-primary-button>
                    {{ __('Save') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>