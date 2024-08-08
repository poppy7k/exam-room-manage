<div id="confirmation-modal" class="fixed z-40 inset-0 hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div id="confirmation-modal-content"
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div id="confirmation-modal-icon"
                        class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                        <!-- Icons will be inserted here based on type -->
                    </div>
                    <div class="my-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 id="confirmation-modal-title" class="text-2xl leading-6 font-medium text-gray-900 mt-1.5">
                        </h3>
                        <div id="confirmation-modal-message" class="mt-2"></div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-200 px-4 pb-4 sm:px-6 sm:flex sm:flex-row-reverse">
                <div class="flex pt-4 pr-4 gap-4">
                    <x-buttons.secondary id="confirmation-modal-cancel-btn" type="button"
                        class="hover:scale-105 py-2 w-12 justify-center">
                        ยกเลิก
                    </x-buttons.secondary>
                    <x-buttons.primary id="confirmation-modal-confirm-btn" type="submit"
                        class="hover:scale-105 py-2 px-12 w-12 justify-center" onclick="">
                        ยืนยัน
                    </x-buttons.primary>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showConfirmationModal(type, title, message, onConfirm) {
        const modal = document.getElementById('confirmation-modal');
        const icon = document.getElementById('confirmation-modal-icon');
        const titleElement = document.getElementById('confirmation-modal-title');
        const messageElement = document.getElementById('confirmation-modal-message');
        const confirmBtn = document.getElementById('confirmation-modal-confirm-btn');
        const cancelBtn = document.getElementById('confirmation-modal-cancel-btn');

        // Reset previous styles
        icon.className =
            'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 sm:h-10 sm:w-10';

        // Apply new styles based on type
        if (type === 'success') {
            icon.innerHTML =
                '<svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 fill-green-600" viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm-1 15l-4-4 1.4-1.4L11 14.2l6.6-6.6L19 9l-8 8Z"/></svg>';
            icon.classList.add('bg-green-100');
            confirmBtn.classList.add('from-green-600', 'to-green-400', 'hover:shadow-green-500/40');
        } else if (type === 'danger') {
            icon.innerHTML =
                '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-red-600 -mt-0.5" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><path d="M23.64,18.1L14.24,2.28c-.47-.8-1.3-1.28-2.24-1.28s-1.77,.48-2.23,1.28L.36,18.1h0c-.47,.82-.47,1.79,0,2.6s1.31,1.3,2.24,1.3H21.41c.94,0,1.78-.49,2.24-1.3s.46-1.78-.01-2.6Zm-10.64-.1h-2v-2h2v2Zm0-4h-2v-6h2v6Z"/></svg>';
            icon.classList.add('bg-red-100');
            confirmBtn.classList.add('from-red-600', 'to-red-400', 'hover:shadow-red-500/40');
        } else if (type === 'info') {
            icon.innerHTML =
                '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-blue-600" viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm-1 15h2v-6h-2v6Zm0-8h2v-2h-2v2Z"/></svg>';
            icon.classList.add('bg-blue-100');
            confirmBtn.classList.add('from-blue-600', 'to-blue-400', 'hover:shadow-blue-500/40');
        } else if (type === 'warning') {
            icon.innerHTML =
                '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-yellow-600" viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm-1 15h2v-6h-2v6Zm0-8h2v-2h-2v2Z"/></svg>';
            icon.classList.add('bg-yellow-100');
            confirmBtn.classList.add('from-yellow-600', 'to-yellow-400', 'hover:shadow-yellow-500/40');
        }

        titleElement.textContent = title;
        messageElement.textContent = message;

        // Set up confirm and cancel actions
        confirmBtn.onclick = () => {
            onConfirm();
            modal.classList.add('hidden');
        };
        cancelBtn.onclick = () => {
            modal.classList.add('hidden');
        };

        modal.classList.remove('hidden');
    }
</script>
