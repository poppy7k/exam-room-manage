 <div class="z-40 sidebar transition-transform duration-500 fixed">
    <aside class="bg-gradient-to-br from-gray-800 to-gray-900 z-50 h-screen w-72 transition-transform duration-300 hidden lg:block col-start-1 col-span-1">
        <!-- Title -->
        <div class="relative border-b border-white/20">
            <div class="flex justify-between px-6 py-6">
                <a class="items-center">
                    <h6 class="block antialiased tracking-normal font-sans text-base font-semibold leading-relaxed text-white">ระบบการจัดการห้องสอบ</h6> 
                </a>
                <button class="col-start-4 pl-2" onclick="openSidebar()">
                    <svg xmlns="http://www.w3.org/2000/svg" id="collapse-arrow" viewBox="0 0 24 24" width="20" height="20" class="fill-white right-0 rotate-180">
                        <path d="M11.83,24a1,1,0,0,1-.71-.29,1,1,0,0,1,0-1.42l8.17-8.17a3,3,0,0,0,0-4.24L11.12,1.71A1,1,0,1,1,12.54.29l8.17,8.17a5,5,0,0,1,0,7.08l-8.17,8.17A1,1,0,0,1,11.83,24Z"/>
                        <path d="M1.83,24a1,1,0,0,1-.71-.29,1,1,0,0,1,0-1.42l9.59-9.58a1,1,0,0,0,0-1.42L1.12,1.71A1,1,0,0,1,2.54.29l9.58,9.59a3,3,0,0,1,0,4.24L2.54,23.71A1,1,0,0,1,1.83,24Z"/>
                    </svg>
                </button>
            </div>
        </div>
        <!-- Menu Lists -->
        <div class="px-6 py-6">
            <ul class="mb-4 flex flex-col gap-1">
                <li>
                    <a aria-current="page" class="active" href="{{ route('building-list') }}">
                        <button class="middle none font-sans font-bold center transition-all duration-500 scale-100 text-s py-3 rounded-lg bg-gradient-to-tr from-green-600 to-green-400 text-white shadow-md shadow-green-500/20 hover:shadow-lg hover:shadow-green-500/40 active:opacity-[0.85] w-full flex items-center gap-4 px-4 capitalize" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="w-5 h-5 text-inherit">
                                <path d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z"></path>
                                <path d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z"></path>
                            </svg>
                            <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-medium capitalize">หน้าแรก</p>
                        </button>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
</div>

<script type="text/javascript">
    function openSidebar() {
      document.querySelector(".sidebar").classList.toggle("-translate-x-56");
      document.querySelector("#content").classList.toggle("-translate-x-56");
      document.querySelector(".breadcrumb").classList.toggle("-translate-x-56");
      document.querySelector("#collapse-arrow").classList.toggle("rotate-180");
    }
</script>