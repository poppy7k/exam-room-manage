<div id="unassigned_applicants_modal"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white w-1/2 p-4 rounded shadow-lg">
        <h2 class="text-xl font-semibold mb-4">ผู้สมัครที่ยังไม่มีที่นั่ง</h2>
        <div class="overflow-y-auto max-h-60 mb-4">
            <ul>
                @foreach ($applicantsWithoutSeats as $applicant)
                    <li>{{ $applicant->name }} ({{ $applicant->id_card }})</li>
                @endforeach
            </ul>
        </div>
        <div class="flex justify-end">
            <button type="button" id="modal_close_button"
                class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">ปิด</button>
        </div>
    </div>
</div>
