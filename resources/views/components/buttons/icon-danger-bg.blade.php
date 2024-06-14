<button {{ $attributes->merge(['class' => 'group rounded-full transition-all duration-500 hover:scale-110 bg-gradient-to-tr from-red-600 to-red-400 hover:shadow-lg hover:shadow-red-500/40']) }}>
    <div {{ $attributes->merge(['class' => 'fill-black transition-all duration-300 group-hover:scale-110 group-hover:fill-white'])}}>
        {{ $slot }}
    </div>
</button>