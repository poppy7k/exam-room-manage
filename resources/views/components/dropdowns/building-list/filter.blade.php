<div x-show="showFilterBuilding" @click.outside="showFilterBuilding = false"  id="filterBuildingModal" class="absolute -translate-x-28 z-40"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 -translate-y-16 scale-90"
    x-transition:enter-end="opacity-100 -translate-y-0 scale-100"
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100 scale-100 -translate-y-0"
    x-transition:leave-end="opacity-0 scale-90 -translate-y-16">
    <div class="relative flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="align-bottom bg-white border-2 border-gray-800/20 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-4 pt-2 pb-4">
                <p class="my-2 font-semibold text-xl">
                    การเรียงลำดับ
                </p>
                <div id="filterSort pt-2">
                    @php
                        $filterItemsSort = [
                            [
                                'value' => 'alphabet_th',
                                'label' => 'เรียงตามตัวอักษร ก - ฮ',
                            ],
                            [
                                'value' => 'alphabet_en',
                                'label' => 'เรียงตามตัวอักษร a - z',
                            ],
                            [
                                'value' => 'seat_desc',
                                'label' => 'เรียงตามจำนวนที่นั่ง มาก - น้อย',
                            ],
                            [
                                'value' => 'seat_asc',
                                'label' => 'เรียงตามจำนวนที่นั่ง น้อย - มาก',
                            ],  
                        ];
                        $currentSort = request()->get('sort', 'alphabet_th');
                    @endphp
                    @foreach($filterItemsSort as $index => $item)
                    <label onclick="window.location.href='{{ route('building-list', ['sort' => $item['value']]) }}'" for="filter-{{ $item['value'] }}" class="flex items-center w-full px-3 py-1.5 cursor-pointer transition-all duration-300 hover:bg-gray-200 rounded-md">
                        <div class="grid mr-3 place-items-center">
                            <div class="inline-flex items-center">
                                <label for="filter-{{ $item['value'] }}" class="relative flex items-center p-0 rounded-full cursor-pointer">
                                    <input name="filter" id="filter-{{ $item['value'] }}" type="radio" value="{{ $item['value'] }}" {{ $currentSort == $item['value'] ? 'checked' : '' }}
                                        class="before:content[''] peer relative h-5 w-5 cursor-pointer appearance-none rounded-full border border-gray-800 text-gray-900 transition-all before:absolute before:top-2/4 before:left-2/4 before:block before:h-12 before:w-12 before:-translate-y-2/4 before:-translate-x-2/4 before:rounded-full before:bg-blue-gray-00 before:opacity-0 before:transition-opacity checked:border-gray-900 checked:before:bg-gray-900 hover:before:opacity-0" />
                                    <span class="absolute text-gray-900 transition-opacity opacity-0 pointer-events-none top-2/4 left-2/4 -translate-y-2/4 -translate-x-2/4 peer-checked:opacity-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 16 16" fill="currentColor">
                                            <circle data-name="ellipse" cx="8" cy="8" r="8"></circle>
                                        </svg>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <p class="block font-sans text-base antialiased font-medium leading-relaxed text-gray-900">
                            {{ $item['label'] }}
                        </p>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>

</script>