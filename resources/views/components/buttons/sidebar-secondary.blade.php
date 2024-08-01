<button {{ $attributes->merge(['class' => 'group flex py-1 px-12 rounded hover:bg-gradient-to-tr hover:shadow-lg hover:shadow-gray-500/40 transition duration-500 ease-in-out hover:from-white hover:to-gray-50 hover:scale-105']) }} >
    <div class="flex gap-2">
        {{ $slot }}
    </div>
</button>