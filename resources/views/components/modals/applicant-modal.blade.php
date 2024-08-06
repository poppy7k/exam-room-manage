<div id="applicants-modal" class="fixed z-40 inset-0 hidden">
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
                        <h3 class="text-2xl leading-6 font-medium text-gray-900""></h3>
                        <div id="applicant-info" class="mb-4 hidden">
                            <!-- Applicant info will be displayed here -->
                        </div>
                        <div id="applicant-list" class="max-h-64 overflow-y-auto">
                            <!-- Applicant list will be populated here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-gray-200 px-4 pb-4 sm:px-6 sm:flex sm:flex-row-reverse">
            <div class="flex pt-4 pr-4 gap-4">
                <x-buttons.secondary id="close-applicants-modal-btn" type="button" class="hover:scale-105 py-2 w-12 justify-center">
                    ยกเลิก
                </x-buttons.secondary>
                <x-buttons.primary id="save-applicant-to-seat-btn" type="submit" class="hover:scale-105 py-2 px-12 w-12 justify-center">
                    บันทึก
                </x-buttons.primary>
            </div>
        </div>
    </div>
</div>

<script>
    function showApplicantModal(seatId, seatRecordId, hasApplicant) {
    currentSeatId = seatId;

    const modalTitle = document.querySelector('#applicants-modal h3');
    const applicantList = document.getElementById('applicant-list');
    const saveButton = document.getElementById('save-applicant-to-seat-btn');
    const applicantInfo = document.getElementById('applicant-info');
    applicantList.innerHTML = '';
    applicantInfo.innerHTML = '';
    applicantInfo.classList.add('hidden');

    let availableApplicants = applicants.filter(applicant => !seats.find(seat => seat.applicant_id === applicant.id));

    availableApplicants.forEach(applicant => {
        const div = document.createElement('div');
        div.classList.add('flex', 'items-center', 'gap-2', 'mb-2', 'applicant-item');
        div.innerHTML = `
            <input type="radio" name="applicant" value="${applicant.id}" class="applicant-radio">
            <p>${applicant.name}</p>
        `;
        applicantList.appendChild(div);
    });

    if (hasApplicant) {
        saveButton.classList.add('hidden'); 
        modalTitle.textContent = 'นำผู้เข้าสอบออกจากที่นั้ง'; 

        const seat = seats.find(seat => seat.row === parseInt(seatId.split('-')[0]) && seat.column === (seatId.split('-')[1].charCodeAt(0) - 64));
        const applicant = applicants.find(applicant => applicant.id === seat.applicant_id);

        if (applicant) {
            applicantInfo.innerHTML = `
                <div>
                    <p><strong>ID Number:</strong> ${applicant.id_number}</p>
                    <p><strong>ID Card:</strong> ${applicant.id_card}</p>
                    <p><strong>Name:</strong> ${applicant.name}</p>
                    <p><strong>Degree:</strong> ${applicant.degree}</p>
                    <p><strong>Position:</strong> ${applicant.position}</p>
                    <p><strong>Department:</strong> ${applicant.department}</p>
                </div>
            `;
            applicantInfo.classList.remove('hidden');
        }

        const removeButton = document.createElement('button');
        removeButton.textContent = 'Remove Applicant';
        removeButton.classList.add('px-4', 'py-2', 'bg-red-500', 'text-white', 'rounded', 'mt-4');
        removeButton.onclick = () => removeApplicantFromSeat(seatRecordId);
        applicantList.appendChild(removeButton);
    } else {
        saveButton.classList.remove('hidden'); 
        modalTitle.textContent = 'เลือกผู้เข้าสอบ'; 
        fetchApplicantsWithoutSeats();
    }

    document.getElementById('applicants-modal').classList.remove('hidden');
}

document.getElementById('close-applicants-modal-btn').addEventListener('click', function() {
    document.getElementById('applicants-modal').classList.add('hidden');
});


</script>