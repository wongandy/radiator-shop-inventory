<x-app-layout>
    <x-slot name="header">
        {{ __('Edit product transfer') }}
    </x-slot>

    @livewire('product-transfers-edit', ['productTransfer' => $productTransfer])
</x-app-layout>
