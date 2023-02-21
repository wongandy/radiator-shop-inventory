<x-app-layout>
    <x-slot name="header">
        {{ __('Create product out') }}
    </x-slot>

    @livewire('product-outs-form', ['type' => 'create'])
</x-app-layout>
