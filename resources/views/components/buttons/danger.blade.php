<button {{ $attributes->merge(['class' => 'group flex px-1 py-1 rounded bg-gradient-to-tr from-red-600 to-red-400 shadow-md shadow-red-500/20 hover:shadow-lg hover:shadow-red-500/40 transition duration-500 ease-in-out hover:scale-105']) }} >
    <div class="flex gap-2 text-white">
        {{ $slot }}
    </div>
</button>