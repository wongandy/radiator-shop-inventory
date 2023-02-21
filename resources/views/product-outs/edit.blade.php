<x-app-layout>
    <x-slot name="header">
        {{ __('Edit product out') }}
    </x-slot>

    @livewire('product-outs-form', ['productOut' => $productOut, 'type' => 'edit'])
</x-app-layout>
