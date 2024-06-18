<div id="filterBuildingModal" class="absolute -translate-x-28 mt-8 z-40 hidden">
    <div class="relative flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-4 pt-2 pb-2">
                <p class="my-2 font-semibold text-xl">
                    การเรียงลำดับ
                </p>
                <div id="filterSort pt-2">
                    @php
                        $filterItemsSort = [
                            [
                                'onclick' => '',
                                'label' => 'เรียงตามตัวอักษร ก - ฮ',
                            ],
                            [
                                'onclick' => '',
                                'label' => 'เรียงตามตัวอักษร a - z',
                            ],
                            [
                                'onclick' => '',
                                'label' => 'เรียงตามจำนวนที่นั่ง มาก - น้อย',
                            ],
                            [
                                'onclick' => '',
                                'label' => 'เรียงตามจำนวนที่นั่ง น้อย - มาก',
                            ],  
                        ];
                    @endphp
                    @foreach($filterItemsSort as $index => $item)
                    <label htmlFor="vertical-list-react" class="flex items-center w-full px-3 py-1.5 cursor-pointer transition-all duration-300 hover:bg-gray-200 rounded-md">
                        <div class="grid mr-3 place-items-center">
                        <div class="inline-flex items-center">
                            <label class="relative flex items-center p-0 rounded-full cursor-pointer" htmlFor="vertical-list-react">
                            <input name="vertical-list" id="vertical-list-react" type="radio"
                                class="before:content[''] peer relative h-5 w-5 cursor-pointer appearance-none rounded-full border border-gray-800 text-gray-900 transition-all before:absolute before:top-2/4 before:left-2/4 before:block before:h-12 before:w-12 before:-translate-y-2/4 before:-translate-x-2/4 before:rounded-full before:bg-blue-gray-00 before:opacity-0 before:transition-opacity checked:border-gray-900 checked:before:bg-gray-900 hover:before:opacity-0" />
                            <span
                                class="absolute text-gray-900 transition-opacity opacity-0 pointer-events-none top-2/4 left-2/4 -translate-y-2/4 -translate-x-2/4 peer-checked:opacity-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 16 16" fill="currentColor">
                                <circle data-name="ellipse" cx="8" cy="8" r="8"></circle>
                                </svg>
                            </span>
                            </label>
                        </div>
                        </div>
                        <p class="block font-sans text-base antialiased font-medium leading-relaxed text-gray-900">
                        {{ $item['label' ]}}
                        </p>
                    </label>
                    @endforeach
                </div>
            </div>
            <div class="px-4 pt-0 pb-4">
                <p class="my-2 font-semibold text-xl">
                    การซ่อน
                </p>
                <div id="filterSort pt-2">
                    @php
                        $filterItemsSort = [
                            [
                                'onclick' => '',
                                'label' => 'ซ่อนอาคารสอบที่ไม่พร้อมใช้งาน',
                            ],
                        ];
                    @endphp
                    @foreach($filterItemsSort as $index => $item)
                    <label htmlFor="vertical-list-react" class="flex items-center w-full px-3 py-1.5 cursor-pointer transition-all duration-300 hover:bg-gray-200 rounded-md">
                        <div class="grid mr-3 place-items-center">
                        <div class="inline-flex items-center">
                            <label class="relative flex items-center p-0 rounded-full cursor-pointer" htmlFor="vertical-list-react">
                            <input name="vertical-list" id="vertical-list-react" type="radio"
                                class="before:content[''] peer relative h-5 w-5 cursor-pointer appearance-none rounded-full border border-gray-800 text-gray-900 transition-all before:absolute before:top-2/4 before:left-2/4 before:block before:h-12 before:w-12 before:-translate-y-2/4 before:-translate-x-2/4 before:rounded-full before:bg-blue-gray-00 before:opacity-0 before:transition-opacity checked:border-gray-900 checked:before:bg-gray-900 hover:before:opacity-0" />
                            <span
                                class="absolute text-gray-900 transition-opacity opacity-0 pointer-events-none top-2/4 left-2/4 -translate-y-2/4 -translate-x-2/4 peer-checked:opacity-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 16 16" fill="currentColor">
                                <circle data-name="ellipse" cx="8" cy="8" r="8"></circle>
                                </svg>
                            </span>
                            </label>
                        </div>
                        </div>
                        <p class="block font-sans text-base antialiased font-medium leading-relaxed text-gray-900">
                        {{ $item['label' ]}}
                        </p>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleFilterBuildingList() {
        document.getElementById('filterBuildingModal').classList.toggle('hidden');
    }
</script>