<div class="p-4 bg-white rounded-lg shadow-xs">
    @if (session('success'))
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
                    <p class="text-sm text-gray-600">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif
        
    <div class="mb-4">
        <x-link href="{{ route('product-transfers.create') }}">Create</x-link>
        <x-text-input wire:model="searchQuery" 
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Search"
                        />
    </div>

    <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
        <div class="overflow-x-auto w-full">
            <table class="w-full whitespace-no-wrap">
                <thead>
                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b">
                    <th class="px-4 py-3">Date transferred</th>
                    <th class="px-4 py-3">From/to</th>
                    <th class="px-4 py-3">Details</th>
                    <th class="px-4 py-3">Notes</th>
                    <th></th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y">
                    @foreach($productTransfers as $productTransfer)
                        <tr class="text-gray-700">
                            <td class="px-4 py-3 text-sm">
                                {{ $productTransfer->date_transferred }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $productTransfer->sendingBranch->name }}/{{ $productTransfer->receivingBranch->name }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                @foreach ($productTransfer->products as $product)
                                    <p>{{ $product->pivot->quantity }} x {{ $product->detail }}</p>
                                @endforeach
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $productTransfer->notes }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <x-link href="{{ route('product-transfers.edit', $productTransfer) }}">Edit</x-link>
                                <x-danger-button wire:click="deleteProductTransfer({{ $productTransfer->id }})" 
                                                type="button"
                                                class=""
                                                onclick="return confirm('Are you sure to delete?') || event.stopImmediatePropagation();"
                                                >
                                    {{ __('Delete') }}
                                </x-danger-button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
                {{ $productTransfers->links() }}
            </div>
        </div>
    </div>
</div>



