<x-app-layout>
    <x-slot name="header">
        {{ __('Edit product in') }}
    </x-slot>

    @livewire('product-ins-form', ['productIn' => $productIn, 'type' => 'edit'])
</x-app-layout>
