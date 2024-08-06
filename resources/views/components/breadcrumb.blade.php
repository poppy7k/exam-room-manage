@props(['breadcrumbs'])

<ol id="breadcrumb" class="breadcrumb -translate-x-44 transition-all duration-500 hidden lg:flex">
    @foreach ($breadcrumbs as $breadcrumb)
        @if ($loop->last)
            <div class="flex items-center">
                @if ($breadcrumb['title'] == 'หน้าหลัก')
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-0 text-inherit" id="Outline" viewBox="0 0 24 24" width="512" height="512"><path d="M23.121,9.069,15.536,1.483a5.008,5.008,0,0,0-7.072,0L.879,9.069A2.978,2.978,0,0,0,0,11.19v9.817a3,3,0,0,0,3,3H21a3,3,0,0,0,3-3V11.19A2.978,2.978,0,0,0,23.121,9.069ZM15,22.007H9V18.073a3,3,0,0,1,6,0Zm7-1a1,1,0,0,1-1,1H17V18.073a5,5,0,0,0-10,0v3.934H3a1,1,0,0,1-1-1V11.19a1.008,1.008,0,0,1,.293-.707L9.878,2.9a3.008,3.008,0,0,1,4.244,0l7.585,7.586A1.008,1.008,0,0,1,22,11.19Z"/></svg>
                @endif
                <li class="breadcrumb-item active pl-3 text-md" aria-current="page">{{ $breadcrumb['title'] }}</li>
            </div>
        @else
            <li class="breadcrumb-item group text-gray-700/80 fill-gray-700/80 text-md">
                <a href="{{ $breadcrumb['url'] }}" class="flex items-center">
                    @if ($breadcrumb['title'] == 'หน้าหลัก')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-inherit group-hover:scale-105 group-hover:fill-green-700 transition-all duration-500" id="Outline" viewBox="0 0 24 24" width="512" height="512"><path d="M23.121,9.069,15.536,1.483a5.008,5.008,0,0,0-7.072,0L.879,9.069A2.978,2.978,0,0,0,0,11.19v9.817a3,3,0,0,0,3,3H21a3,3,0,0,0,3-3V11.19A2.978,2.978,0,0,0,23.121,9.069ZM15,22.007H9V18.073a3,3,0,0,1,6,0Zm7-1a1,1,0,0,1-1,1H17V18.073a5,5,0,0,0-10,0v3.934H3a1,1,0,0,1-1-1V11.19a1.008,1.008,0,0,1,.293-.707L9.878,2.9a3.008,3.008,0,0,1,4.244,0l7.585,7.586A1.008,1.008,0,0,1,22,11.19Z"/></svg>
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
