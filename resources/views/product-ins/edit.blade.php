<x-app-layout>
    <x-slot name="header">
        {{ __('Edit product in') }}
    </x-slot>

    @livewire('product-ins-edit', ['productIn' => $productIn])
</x-app-layout>
