<button {{ $attributes->merge(['class' => 'group py-1 rounded bg-gradient-to-tr from-white to-gray-50 shadow-md shadow-gray-500/20 hover:shadow-lg hover:shadow-gray-500/40 transition duration-500 ease-in-out hover:scale-105 px-12']) }} >
    <div class="flex justify-center gap-2 text-black">
        {{ $slot }}
    </div>
</button>