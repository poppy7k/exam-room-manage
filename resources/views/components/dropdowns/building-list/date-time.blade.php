<div x-show="showDateTimeBuilding" @click.outside="showDateTimeBuilding = false"  id="filterBuildingModal" class="absolute -translate-x-60 z-40 pt-4 px-4 pb-20 h-max"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 -translate-y-16 scale-90"
    x-transition:enter-end="opacity-100 -translate-y-0 scale-100"
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100 scale-100 -translate-y-0"
    x-transition:leave-end="opacity-0 scale-90 -translate-y-16">
    <div class="relative flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="align-bottom bg-white border-2 border-gray-800/20 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-4 pt-2 pb-1">
                <p class="my-2 font-semibold text-xl">
                    เวลาที่ต้องการ
                </p>
                <div class="flex mb-4 justify-between gap-4 w-max">
                    <div class="">
                        <label for="exam_date" class="block font-semibold">วันที่การสอบ</label>
                        <input type="date" id="exam_date" name="exam_date" class="w-36 my-2 px-3 py-1.5 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
                    </div>
                    <div class="">
                        <label for="exam_start_time" class="block font-semibold whitespace-nowrap">เวลาเริ่มการสอบ</label>
                        <input list="time_list" type="text" id="exam_start_time" name="exam_start_time" placeholder="เวลาเริ่ม" required class="w-36 my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
                        <span id="exam_start_time_error" class="error-message" style="color: red; display: none;">* กรุณากรอกเวลา 00:00 และหน่วยนาทีเป็น 00, 30 เท่านั้น!</span>
                    </div>
                    <div class="">
                        <label for="exam_end_time" class="block font-semibold whitespace-nowrap">เวลาสิ้นสุดการสอบ</label>
                        <input list="time_list" type="text" id="exam_end_time" name="exam_end_time" placeholder="เวลาสิ้นสุด" required class="w-36 my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
                        <span id="exam_end_time_error" class="error-message" style="color: red; display: none;">* กรุณากรอกเวลา 00:00 และหน่วยนาทีเป็น 00, 30 เท่านั้น!</span>
                        <datalist id="time_list">
                            @for ($hour = 0; $hour < 24; $hour++)
                                @for ($minute = 0; $minute < 60; $minute += 30)
                                    <option value="{{ sprintf('%02d', $hour) }}:{{ sprintf('%02d', $minute) }}"></option>
                                @endfor
                            @endfor
                        </datalist>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

</script>