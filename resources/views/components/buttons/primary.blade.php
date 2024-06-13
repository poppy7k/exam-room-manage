<button {{ $attributes->merge(['class' => 'group flex px-1 py-1 rounded bg-gradient-to-tr from-green-600 to-green-400 shadow-md shadow-green-500/20 hover:shadow-lg hover:shadow-green-500/40 transition duration-500 ease-in-out hover:scale-105']) }} >
    <div class="flex gap-2 text-white">
        {{ $slot }}
    </div>
</button>