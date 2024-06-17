<div id="sidebar" class="z-40 sidebar -translate-x-56 transition-all ease-in-out duration-500 fixed">
    <aside class="bg-gradient-to-br from-gray-800 to-gray-900 z-50 h-screen w-72 transition-transform duration-300 hidden lg:block col-start-1 col-span-1">
        <!-- Title -->
        <div class="relative border-b border-white/20">
            <div class="flex justify-between px-6 py-6">
                <a class="items-center">
                    <h6 class="block antialiased tracking-normal font-sans text-base font-semibold leading-relaxed text-white">ระบบการจัดการห้องสอบ</h6> 
                </a>
                <button class="col-start-4 pl-2" onclick="openSidebar()">
                    <svg xmlns="http://www.w3.org/2000/svg" id="collapse-arrow" viewBox="0 0 24 24" width="20" height="20" class="fill-white right-0">
                        <path d="M11.83,24a1,1,0,0,1-.71-.29,1,1,0,0,1,0-1.42l8.17-8.17a3,3,0,0,0,0-4.24L11.12,1.71A1,1,0,1,1,12.54.29l8.17,8.17a5,5,0,0,1,0,7.08l-8.17,8.17A1,1,0,0,1,11.83,24Z"/>
                        <path d="M1.83,24a1,1,0,0,1-.71-.29,1,1,0,0,1,0-1.42l9.59-9.58a1,1,0,0,0,0-1.42L1.12,1.71A1,1,0,0,1,2.54.29l9.58,9.59a3,3,0,0,1,0,4.24L2.54,23.71A1,1,0,0,1,1.83,24Z"/>
                    </svg>
                </button>
            </div>
        </div>
        <!-- Menu Lists -->
        <div class="px-6 py-6">
            <ul class="mb-4 flex flex-col gap-6">
                @php
                    $menuItems = [
                        [
                            'route' => 'index',
                            'label' => 'หน้าหลัก',
                            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="sidebar-menu-icon w-5 h-5 mt-0.5 translate-x-8 text-inherit transition-all duration-500 ease-in-out"><path d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z"></path><path d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z"></path></svg>',
                        ],
                        [
                            'route' => 'building-list',
                            'label' => 'จัดการห้องสอบ',
                            'icon' => '<svg id="Layer_1" height="512" class="sidebar-menu-icon w-5 h-5 mt-0.5 translate-x-8 text-inherit transition-all duration-500 ease-in-out" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><path d="m7 14a1 1 0 0 1 -1 1h-1a1 1 0 0 1 0-2h1a1 1 0 0 1 1 1zm4-1h-1a1 1 0 0 0 0 2h1a1 1 0 0 0 0-2zm-5 4h-1a1 1 0 0 0 0 2h1a1 1 0 0 0 0-2zm5 0h-1a1 1 0 0 0 0 2h1a1 1 0 0 0 0-2zm-5-12h-1a1 1 0 0 0 0 2h1a1 1 0 0 0 0-2zm5 0h-1a1 1 0 0 0 0 2h1a1 1 0 0 0 0-2zm-5 4h-1a1 1 0 0 0 0 2h1a1 1 0 0 0 0-2zm5 0h-1a1 1 0 0 0 0 2h1a1 1 0 0 0 0-2zm13 1v9a5.006 5.006 0 0 1 -5 5h-14a5.006 5.006 0 0 1 -5-5v-14a5.006 5.006 0 0 1 5-5h6a5.006 5.006 0 0 1 5 5h3a5.006 5.006 0 0 1 5 5zm-19 12h9v-17a3 3 0 0 0 -3-3h-6a3 3 0 0 0 -3 3v14a3 3 0 0 0 3 3zm17-12a3 3 0 0 0 -3-3h-3v15h3a3 3 0 0 0 3-3zm-3 3a1 1 0 1 0 1 1 1 1 0 0 0 -1-1zm0 4a1 1 0 1 0 1 1 1 1 0 0 0 -1-1zm0-8a1 1 0 1 0 1 1 1 1 0 0 0 -1-1z"/>/svg>',
                        ],
                        [
                            'route' => 'exam-list',
                            'label' => 'จัดการการสอบ',
                            'icon' => '<svg id="Layer_1" height="512" class="sidebar-menu-icon w-5 h-5 mt-0.5 translate-x-8 text-inherit transition-all duration-500 ease-in-out" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><path d="m16 17a1 1 0 0 1 0 2h-1a1 1 0 0 1 0-2zm-2-2a1 1 0 0 1 -1-1v-1h-2v1a1 1 0 0 1 -2 0v-4a3 3 0 0 1 6 0v4a1 1 0 0 1 -1 1zm-1-4v-1a1 1 0 0 0 -2 0v1zm-1.711 5.3-1.612 1.63a.25.25 0 0 1 -.344.01l-.616-.64a1 1 0 0 0 -1.434 1.4l.626.644a2.255 2.255 0 0 0 3.186 0l1.616-1.644a1 1 0 0 0 -1.422-1.4zm9.711-9.643v12.343a5.006 5.006 0 0 1 -5 5h-8a5.006 5.006 0 0 1 -5-5v-14a5.006 5.006 0 0 1 5-5h6.343a4.969 4.969 0 0 1 3.536 1.465l1.656 1.656a4.969 4.969 0 0 1 1.465 3.536zm-4.535-3.778a3.042 3.042 0 0 0 -.465-.379v2.5h2.5a3.042 3.042 0 0 0 -.38-.465zm2.535 4.121h-3a2 2 0 0 1 -2-2v-3h-6a3 3 0 0 0 -3 3v14a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3z"/></svg>',
                        ]
                    ];
                @endphp
                @foreach($menuItems as $index => $item)
                <li class="sidebar-menu-list translate-x-3 transition-all duration-500">
                    <a aria-current="page" class="active" href="{{ route($item['route']) }}">
                        @if(session('sidebar') == (string)($index + 1))
                            <x-buttons.primary type="button" class="sidebar-menu-button w-full py-3 px-12 rounded-lg pl-10 justify-end h-12" onclick="">
                                {!! $item['icon'] !!}
                                <p class="sidebar-menu-label hidden">{{ $item['label'] }}</p>
                            </x-buttons.primary>
                        @else
                            <x-buttons.secondary type="button" class="sidebar-menu-button w-full py-3 px-12 rounded-lg pl-10 justify-end h-12" onclick="">
                                {!! $item['icon'] !!}
                                <p class="sidebar-menu-label hidden">{{ $item['label'] }}</p>
                            </x-buttons.secondary>
                        @endif
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        
    </aside>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let isSidebarCollapse = localStorage.getItem('isSidebarCollapse');

        if (isSidebarCollapse === 'false') {
            document.querySelector(".sidebar").classList.toggle("transition-all");
            document.querySelector(".sidebar").classList.toggle("duration-500");
            document.querySelector(".sidebar").classList.toggle("-translate-x-56");
            document.querySelector("#content").classList.toggle("lg:pl-52");
            document.querySelector("#content").classList.toggle("transition-all");
            document.querySelector("#content").classList.toggle("duration-500");
            document.querySelector(".breadcrumb").classList.toggle("-translate-x-44");
            document.querySelector(".breadcrumb").classList.toggle("transition-all");
            document.querySelector(".breadcrumb").classList.toggle("duration-500");
            document.querySelector("#collapse-arrow").classList.toggle("rotate-180");

            document.querySelectorAll(".sidebar-menu-list").forEach(element => {
                element.classList.toggle("translate-x-3");
                element.classList.toggle("transition-all");
                element.classList.toggle("duration-500");
            });
            document.querySelectorAll(".sidebar-menu-button").forEach(element => {
                element.classList.toggle("justify-start");
                element.classList.toggle("justify-end");
            });
            document.querySelectorAll(".sidebar-menu-icon").forEach(element => {
                element.classList.toggle("translate-x-8");
                element.classList.toggle("scale-110");
                element.classList.toggle("transition-all");
                element.classList.toggle("duration-500");
            });
            document.querySelectorAll(".sidebar-menu-label").forEach(element => {
                element.classList.toggle("hidden");
            });
        } else {
            // Default closed state
        }

        // Toggle sidebar state
    });

    function openSidebar() {
        let isOpen = document.querySelector(".sidebar").classList.toggle("-translate-x-56");
        document.querySelector("#content").classList.toggle("lg:pl-52");
        document.querySelector(".breadcrumb").classList.toggle("-translate-x-44");
        document.querySelector("#collapse-arrow").classList.toggle("rotate-180");

        document.querySelectorAll(".sidebar-menu-list").forEach(element => {
            element.classList.toggle("translate-x-3");
        });
        document.querySelectorAll(".sidebar-menu-button").forEach(element => {
            element.classList.toggle("justify-start");
            element.classList.toggle("justify-end");
        });
        document.querySelectorAll(".sidebar-menu-icon").forEach(element => {
            element.classList.toggle("translate-x-8");
            element.classList.toggle("scale-110");
        });
        document.querySelectorAll(".sidebar-menu-label").forEach(element => {
            element.classList.toggle("hidden");
        });

        addClassById('sidebar', 'transition-all')
        addClassById('sidebar', 'duration-500')
        addClassById('content', 'transition-all')
        addClassById('content', 'duration-500')
        addClassById('breadcrumb', 'transition-all')
        addClassById('breadcrumb', 'duration-500')

        addClassByClass('sidebar-menu-list', 'transition-all')
        addClassByClass('sidebar-menu-list', 'duration-500')
        addClassByClass('sidebar-menu-icon', 'transition-all')
        addClassByClass('sidebar-menu-icon', 'duration-500')
        
        // Save state to local storage
        localStorage.setItem('isSidebarCollapse', isOpen ? 'true' : 'false');
    }

    function addClassById(elementId, className) {
        const element = document.getElementById(elementId);
        if (!element) return; // ถ้าไม่มีองค์ประกอบ return

        if (!element.classList.contains(className)) {
            element.classList.add(className);
        }
    }
    
    function addClassByClass(elementClass, className) {
        const elements = document.getElementsByClassName(elementClass);
        for (let i = 0; i < elements.length; i++) {
            if (!elements[i].classList.contains(className)) {
                elements[i].classList.add(className);
            }
        }
    }


</script>