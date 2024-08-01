<button {{ $attributes->merge(['class' => 'group flex px-1 py-1 rounded bg-gradient-to-tr from-cyan-600 to-cyan-400 shadow-md shadow-cyan-500/20 hover:shadow-lg hover:shadow-cyan-500/40 transition duration-500 ease-in-out hover:scale-105']) }} >
    <div class="flex gap-2 text-white fill-white">
        {{ $slot }}
    </div>
</button>