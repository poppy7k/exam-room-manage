<div id="examiners-modal" class="fixed z-40 inset-0 hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75 w-screen h-screen"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 pt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full mr-4">
                        <div>
                        <h3 class="text-2xl leading-6 font-medium text-gray-900"">เลือกผู้คุมสอบ</h3>
                        <div class="mb-4 mt-4">
                            <input type="text" id="search-staff-input" class="w-full px-5 py-2 rounded-full ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none" placeholder="ค้นหาชื่อผู้คุมสอบ">
                        </div>
                        <div class="mt-4">
                            <div id="staff-list" class="max-h-64 overflow-y-auto"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-gray-200 px-4 pb-4 sm:px-6 sm:flex sm:flex-row-reverse">
            <div class="flex pt-4 pr-4 gap-4">
                <x-buttons.secondary id="close-modal-btn" type="button" class="hover:scale-105 py-2 w-12 justify-center">
                    ยกเลิก
                </x-buttons.secondary>
                <x-buttons.primary id="save-examiners-btn" class="hover:scale-105 py-2 px-12 w-12 justify-center">
                    บันทึก
                </x-buttons.primary>
            </div>
        </div>
    </div>
</div>