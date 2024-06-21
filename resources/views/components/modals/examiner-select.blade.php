<!-- Examiner selection modal -->
<div id="examiners-modal" class="fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg p-6 w-1/2">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">เลือกผู้คุมสอบ</h3>
            <button id="close-modal-btn" class="text-red-500">&times;</button>
        </div>
        <input type="text" id="search-staff-input" class="w-full p-2 border border-gray-300 rounded mb-4" placeholder="ค้นหาชื่อผู้คุมสอบ">
        <div id="staff-list" class="max-h-64 overflow-y-auto">
            <!-- Staff list will be populated here -->
        </div>
        <div class="flex justify-end mt-4">
            <button id="save-examiners-btn" class="px-5 py-2 bg-blue-500 text-white rounded">บันทึก</button>
        </div>
    </div>
</div>