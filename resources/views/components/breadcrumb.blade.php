@props(['breadcrumbs'])

<ol class="breadcrumb transition-transform duration-500 flex">
    @foreach ($breadcrumbs as $breadcrumb)
        @if ($loop->last)
            @if ($breadcrumb['title'] == 'หน้าหลัก')
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="w-5 h-5 mt-0 text-inherit">
                    <path d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z"></path>
                    <path d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z"></path>
                </svg>
            @endif
            <li class="breadcrumb-item active pl-3 text-md" aria-current="page">{{ $breadcrumb['title'] }}</li>
        @else
            <li class="breadcrumb-item group text-gray-700/80 text-md">
                <a href="{{ $breadcrumb['url'] }}" class="flex items-center">
                    @if ($breadcrumb['title'] == 'หน้าหลัก')
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="w-5 h-5 text-inherit -mt-1 group-hover:scale-105 group-hover:text-green-700 transition-all duration-500">
                            <path d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z"></path>
                            <path d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z"></path>
                        </svg>
                    @endif
                    <p class="group-hover:scale-105 group-hover:text-green-700 transition-all duration-500 pl-3">
                        {{ $breadcrumb['title'] }}
                    </p>
                    <p class="pl-3 text-black">/</p>
                </a>
            </li>
        @endif
    @endforeach
</ol>
