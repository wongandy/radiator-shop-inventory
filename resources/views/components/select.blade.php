<select {{ $attributes->merge(['class' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus-within:text-primary-600 focus:border-primary-300 focus:ring-primary-200 focus:ring focus:ring-opacity-50']) }}>
    {{ $slot }}
</select>