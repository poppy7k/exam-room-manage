<div id="editRoomModal" class="fixed z-40 inset-0 hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75 w-screen h-screen"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="editRoomForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="bg-white px-4 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 pt-3 text-center sm:mt-0 sm:ml-4 sm:text-left divide-y-2 w-full mr-4">
                            <h3 class="text-2xl leading-6 font-medium text-gray-900" id="modal-title">แก้ไขข้อมูลห้องสอบ
                            </h3>
                            <div class="mt-4">
                                <div class="mb-4 mt-4">
                                    <label for="floor_edit" class="block text-gray-700 font-semibold">ชั้น</label>
                                    <input type="text" name="floor_edit" id="floor_edit"
                                        class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
                                </div>
                                <div class="mb-4">
                                    <label for="room_edit"
                                        class="block text-gray-700 font-semibold">ชื่อของห้องสอบ</label>
                                    <input type="text" name="room_edit" id="room_edit"
                                        class="w-full my-2 px-3 py-2 rounded ring-1 shadow-sm ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-600 transition-all duration-300 outline-none">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-200 px-4 pb-4 sm:px-6 sm:flex sm:flex-row-reverse">
                    <div class="flex pt-4 pr-4 gap-4">
                        <x-buttons.secondary type="button" class="hover:scale-105 py-2 w-12 justify-center"
                            onclick="closeRoomModal()">
                            Cancel
                        </x-buttons.secondary>
                        <x-buttons.primary type="submit" class="hover:scale-105 py-2 px-12 w-12 justify-center">
                            Save
                        </x-buttons.primary>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openRoomEditModal(room, floor, room_id) {
        document.getElementById('editRoomForm').action = `/rooms/${room_id}/update`;
        document.getElementById('floor_edit').value = floor;
        document.getElementById('room_edit').value = room;
        document.getElementById('editRoomModal').classList.remove('hidden');
    }

    function closeRoomModal() {
        document.getElementById('editRoomModal').classList.add('hidden');
    }

    document.getElementById('editRoomForm').addEventListener('submit', function(event) {
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
                    alert(data.error || 'Failed to update the room.');
                }
            })
            .catch(error => console.error('Error:', error));
    });
</script>
