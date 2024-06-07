<a href="{{ $route }}" class="">
    <button {{ $attributes->merge(['class' => 'group rounded-full transition-all duration-500 hover:scale-110 bg-gradient-to-tr hover:from-cyan-600 hover:to-cyan-400 hover:border-white hover:shadow-lg']) }}>
        <div {{ $attributes->merge(['class' => 'fill-black transition-all duration-300 group-hover:scale-110 group-hover:fill-white'])}}>
            {{ $slot }}
        </div>
    </button>
</a>