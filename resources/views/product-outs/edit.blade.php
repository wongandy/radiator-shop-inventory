<x-app-layout>
    <x-slot name="header">
        {{ __('Edit product out') }}
    </x-slot>

    @livewire('product-outs-edit', ['productOut' => $productOut])
</x-app-layout>
