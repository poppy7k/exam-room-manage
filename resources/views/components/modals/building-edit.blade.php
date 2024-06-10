<div id="editModal" class="fixed z-30 inset-0 hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75 w-screen h-screen"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="bg-white px-4 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 pt-3 text-center sm:mt-0 sm:ml-4 sm:text-left divide-y-2 w-full mr-4">
                            <h3 class="text-2xl leading-6 font-medium text-gray-900" id="modal-title">แก้ไขข้อมูลอาคารสอบ</h3>
                            <div class="mt-4">
                                <div class="mb-4 mt-4">
                                    <label for="building_th" class="block text-gray-700 font-semibold">ชื่ออาคารสอบ (ภาษาไทย)</label>
                                    <input type="text" name="building_th" id="building_th" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                </div>
                                <div class="mb-4">
                                    <label for="building_en" class="block text-gray-700 font-semibold">ชื่ออาคารสอบ (English)</label>
                                    <input type="text" name="building_en" id="building_en" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                </div>
                                <div class="mb-4">
                                    <label for="building_image" class="block text-gray-700 font-semibold">รูปภาพของอาคารสอบ</label>
                                    <input type="file" name="building_image" id="building_image" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-200 px-4 pb-4 sm:px-6 sm:flex sm:flex-row-reverse">
                    <div class="flex pt-4 pr-4 gap-4">
                        <x-buttons.secondary type="button" class="hover:scale-105 py-2 w-12" onclick="closeModal()">
                            Cancel
                        </x-buttons.secondary>
                        <x-buttons.primary type="submit" class="hover:scale-105 py-2 w-12 justify-center" onclick="">
                            Save
                        </x-buttons.primary>
                        
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openModal(building) {
        document.getElementById('editForm').action = `/buildings/${building.id}/ajax`;
        document.getElementById('building_th').value = building.building_th;
        document.getElementById('building_en').value = building.building_en;
        document.getElementById('editModal').classList.remove('hidden');
        setTimeout(() => {
            modalCl.remove('opacity-0')
            modalCl.remove('-translate-y-10')
            modalCl.remove('scale-150')
        }, 100);
    }
    function closeModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    document.getElementById('editForm').addEventListener('submit', function(event) {
        event.preventDefault();
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
</script>