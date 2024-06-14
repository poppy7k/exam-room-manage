@props(['title'])

<div {{ $attributes->merge(['class' => 'relative'])}}>
    {{ $slot }}
    <div class="hidden group-hover:block group-hover:translate-y-1 mt-2 absolute bg-gray-700/80 text-white rounded px-2 py-1 text-xs whitespace-nowrap z-50">
        {{ $title }}
    </div>
</div>