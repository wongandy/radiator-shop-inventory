<x-app-layout>
    <x-slot name="header">
        {{ __('Create product') }}
    </x-slot>

    @if ($message = Session::get('success'))
        <div class="inline-flex w-full mb-4 overflow-hidden bg-white rounded-lg shadow-md">
            <div class="flex items-center justify-center w-12 bg-green-500">
                <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                    <path
                            d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z">
                    </path>
                </svg>
            </div>

            <div class="px-4 py-2 -mx-3">
                <div class="mx-3">
                    <span class="font-semibold text-green-500">Success</span>
                    <p class="text-sm text-gray-600">{{ $message }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="p-4 bg-white rounded-lg shadow-md">

        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <div class="mt-4">
                <x-input-label for="make" :value="__('Make')"/>
                <x-text-input type="text"
                         id="make"
                         name="make"
                         class="block w-full {{ $errors->has('make') ? 'border-red-500' : '' }}"
                         value="{{ old('make') }}"
                         autofocus
                         />
                <x-input-error :messages="$errors->get('make')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="brand" :value="__('Brand')"/>
                <x-text-input type="text"
                         id="brand"
                         name="brand"
                         class="block w-full {{ $errors->has('brand') ? 'border-red-500' : '' }}"
                         value="{{ old('brand') }}"
                         />
                <x-input-error :messages="$errors->get('brand')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="model" :value="__('Model')"/>
                <x-text-input type="text"
                         id="model"
                         name="model"
                         class="block w-full {{ $errors->has('model') ? 'border-red-500' : '' }}"
                         value="{{ old('model') }}"
                         />
                <x-input-error :messages="$errors->get('model')" class="mt-2" />
            </div>

            <div class="flex">
                <div class="w-1/2 mr-2 w-full">
                    <div class="mt-4">
                        <x-input-label for="year_start" :value="__('Year start')"/>
                        <x-text-input type="number"
                                id="year_start"
                                name="year_start"
                                class="block w-full {{ $errors->has('year_start') ? 'border-red-500' : '' }}"
                                value="{{ old('year_start') }}"
                                step="1"
                                />
                        <x-input-error :messages="$errors->get('year_start')" class="mt-2" />
                    </div>
                </div>
                <div class="w-1/2 ml-2 w-full">
                    <div class="mt-4">
                        <x-input-label for="year_end" :value="__('Year end')"/>
                        <x-text-input type="number"
                                id="year_end"
                                name="year_end"
                                class="block w-full {{ $errors->has('year_end') ? 'border-red-500' : '' }}"
                                value="{{ old('year_end') }}"
                                step="1"
                                />
                        <x-input-error :messages="$errors->get('year_end')" class="mt-2" />
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <x-input-label for="transmission" :value="__('Transmission')"/>

                <x-select name="transmission" id="transmission" class="{{ $errors->has('transmission') ? 'border-red-500' : '' }}">
                    @foreach (App\Enums\Products\TransmissionEnum::cases() as $transmission)
                        <option value="{{ $transmission->value }}" @selected(old('transmission') == $transmission->value)>{{ $transmission->value }}</option>
                    @endforeach
                </x-select>
                <x-input-error :messages="$errors->get('transmission')" class="mt-2" />
            </div>
            
            
            <div class="flex">
                <div class="w-1/2 mr-2 w-full">
                    <div class="mt-4">
                        <x-input-label for="thickness_number" :value="__('Thickness number')"/>
                        <x-text-input type="text"
                                id="thickness_number"
                                name="thickness_number"
                                class="block w-full {{ $errors->has('thickness_number') ? 'border-red-500' : '' }}"
                                value="{{ old('thickness_number') }}"
                                />
                        <x-input-error :messages="$errors->get('thickness_number')" class="mt-2" />
                    </div>
                </div>

                <div class="w-1/2 ml-2 w-full">
                    <div class="mt-4">
                        <x-input-label for="thickness" :value="__('Thickness')"/>

                        <x-select name="thickness" id="thickness" class="{{ $errors->has('thickness') ? 'border-red-500' : '' }}">
                            @foreach (App\Enums\Products\ThicknessEnum::cases() as $thickness)
                                <option value="{{ $thickness->value }}" @selected(old('thickness') == $thickness->value)>{{ $thickness->value }}</option>
                            @endforeach
                        </x-select>
                        <x-input-error :messages="$errors->get('thickness')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <x-input-label for="stock_number" :value="__('Stock number')"/>
                <x-text-input type="text"
                        id="stock_number"
                        name="stock_number"
                        class="block w-full {{ $errors->has('stock_number') ? 'border-red-500' : '' }}"
                        value="{{ old('stock_number') }}"
                        />
                <x-input-error :messages="$errors->get('stock_number')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="enterex_price" :value="__('Enterex price')"/>
                <x-text-input type="number"
                         id="enterex_price"
                         name="enterex_price"
                         class="block w-full {{ $errors->has('enterex_price') ? 'border-red-500' : '' }}"
                         step="any"
                         value="{{ old('enterex_price') }}"
                         />
                <x-input-error :messages="$errors->get('enterex_price')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="price" :value="__('Price')"/>
                <x-text-input type="number"
                         id="price"
                         name="price"
                         class="block w-full {{ $errors->has('price') ? 'border-red-500' : '' }}"
                         step="any"
                         value="{{ old('price') }}"
                         />
                <x-input-error :messages="$errors->get('price')" class="mt-2" />
            </div>
            
            <div class="mt-4">
                <x-input-label for="notes" :value="__('Notes')"/>
                <x-textarea id="notes" name="notes" class="block w-full {{ $errors->has('notes') ? 'border-red-500' : '' }}">{{ old('notes') }}</x-textarea>
                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-primary-button>
                    {{ __('Save') }}
                </x-primary-button>
            </div>
        </form>

    </div>
</x-app-layout>
