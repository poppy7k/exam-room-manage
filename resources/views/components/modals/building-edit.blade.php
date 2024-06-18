<div id="editBuildingModal" class="fixed z-40 inset-0 hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75 w-screen h-screen"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="editBuildingForm" method="POST" enctype="multipart/form-data" onsubmit="return validateEditForm()">
                @csrf
                @method('PUT')
                <div class="bg-white px-4 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 pt-3 text-center sm:mt-0 sm:ml-4 sm:text-left divide-y-2 w-full mr-4">
                            <h3 class="text-2xl leading-6 font-medium text-gray-900" id="modal-title">แก้ไขข้อมูลอาคารสอบ</h3>
                            <div class="mt-4">
                                <div class="mb-4 mt-4">
                                    <label for="building_th_edit" class="block text-gray-700 font-semibold">ชื่ออาคารสอบ (ภาษาไทย)</label>
                                    <input type="text" name="building_th_edit" id="building_th_edit" class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
                                    <span id="building_th_edit_error" class="error-message" style="color: red; display: none;">* กรุณากรอกชื่ออาคารด้วยภาษาไทยหรือตัวเลขเท่านั้น!</span>
                                </div>
                                <div class="mb-4">
                                    <label for="building_en_edit" class="block text-gray-700 font-semibold">ชื่ออาคารสอบ (English)</label>
                                    <input type="text" name="building_en_edit" id="building_en_edit" class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
                                    <span id="building_en_edit_error" class="error-message" style="color: red; display: none;">* กรุณากรอกชื่ออาคารด้วยภาษาอังกฤษหรือตัวเลขเท่านั้น!</span>
                                </div>
                                <div class="mb-4">
                                    <label for="building_map_url_edit" class="block font-semibold">ลิ้งค์แผนที่ของอาคารสอบ</label>
                                    <input type="text" id="building_map_url_edit" name="building_map_url_edit" placeholder="กรอกลิ้งค์แผนที่ของอาคารสอบ" class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
                                </div>
                                <div class="mb-4">
                                    <label for="building_image_edit" class="block text-gray-700 font-semibold">รูปภาพของอาคารสอบ</label>
                                    <input type="file" name="building_image_edit" id="building_image_edit" class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-200 px-4 pb-4 sm:px-6 sm:flex sm:flex-row-reverse">
                    <div class="flex pt-4 pr-4 gap-4">
                        <x-buttons.secondary type="button" class="hover:scale-105 py-2 w-12 justify-center" onclick="closeBuildingModal()">
                            Cancel
                        </x-buttons.secondary>
                        <x-buttons.primary type="submit" class="hover:scale-105 py-2 px-12 w-12 justify-center" onclick="">
                            Save
                        </x-buttons.primary>
                        
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openBuildingEditModal(building) {
        document.getElementById('editBuildingForm').action = `/buildings/${building.id}/ajax`;
        document.getElementById('building_th_edit').value = building.building_th;
        document.getElementById('building_en_edit').value = building.building_en;
        document.getElementById('building_map_url_edit').value = building.building_map_url;
        document.getElementById('editBuildingModal').classList.remove('hidden');
    }

    function closeBuildingModal() {
        document.getElementById('editBuildingModal').classList.add('hidden');
    }

    document.getElementById('editBuildingForm').addEventListener('submit', function(event) {
        event.preventDefault();
        if (!validateEditForm()) {
            return false; // Cancel submit if validation fails
        }
        var formData = new FormData(this);
        var action = this.action;

        fetch(action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.success);
                location.reload();
            } else {
                alert(data.error || 'Failed to update the building.');
            }
        })
        .catch(error => console.error('Error:', error));
    });

    function validateEditForm() {
        var isValid = true;
        var buildingTh = document.getElementById('building_th_edit').value.trim();
        var buildingEn = document.getElementById('building_en_edit').value.trim();
        var thaiPattern = /^[ก-๙0-9\s]+$/;
        var englishPattern = /^[A-Za-z0-9\s]+$/;
        var buildingThError = document.getElementById('building_th_edit_error');
        var buildingEnError = document.getElementById('building_en_edit_error');
        if (!thaiPattern.test(buildingTh)) {
            buildingThError.style.display = 'block';
            isValid = false;
        } else {
            buildingThError.style.display = 'none';
        }
        if (!englishPattern.test(buildingEn)) {
            buildingEnError.style.display = 'block';
            isValid = false;
        } else {
            buildingEnError.style.display = 'none';
        }
        return isValid;
    }
</script>