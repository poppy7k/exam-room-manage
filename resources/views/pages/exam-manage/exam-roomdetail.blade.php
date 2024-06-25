@extends('layouts.main')

@section('content')
<div class="flex flex-col w-full max-h-full">
    <div class="flex justify-between items-center">
        <div class="flex">
            <p class="font-semibold align-baseline text-2xl">
                {{ $room->room }}
            </p>
            <p class="font-normal text-md ml-4 mt-1.5"> ชั้น </p>
            <p class="font-bold ml-1 mt-1.5"> {{ $room->floor }}</p>
            <p class="font-normal text- justify-start ml-4 mt-1.5"> ที่นั่งว่าง </p>
            <p id="validSeatCount" class="font-bold ml-1 mt-1.5 text-green-800"> {{ $room->valid_seat }}</p>
            <p class="font-normal text- justify-start ml-4 mt-1.5"> ที่นั่งทั้งหมด </p>
            <p id="totalSeatCount" class="font-bold ml-1 mt-1.5"> {{ $room->total_seat }}</p>
            <p class="font-normal text- justify-start ml-4 mt-1.5"> แถว </p>
            <p id="row-count" class="font-bold ml-1 mt-1.5 text-black"> {{ $room->rows }}</p>
            <p class="font-normal text- justify-start ml-4 mt-1.5"> คอลัมน์ </p>
            <p id="column-count" class="font-bold ml-1 mt-1.5 text-black"> {{ $room->columns }}</p>
        </div>
        <div class="flex">
            <x-buttons.primary id="select-examiners-btn" class="px-5 py-2 rounded-lg bg-blue-500 text-white">
                เลือกผู้คุมสอบ
            </x-buttons.primary>
        </div>
    </div>
    <div class="bg-white shadow-md my-3 rounded-lg max-h-screen flex flex-col">
        <div id="seat-container" class="grid gap-2 overflow-x-auto overflow-y-auto w-full h-96">
            <!-- Seats will be generated by JavaScript -->
        </div>
    </div>
    <div class="bg-white shadow-md my-3 rounded-lg max-h-screen flex flex-col p-4">
        <h2 class="text-xl font-semibold mb-4">ผู้คุมสอบ</h2>
        <ul id="selected-examiners-list">
            @foreach($staffs as $staff)
                <li>{{ $staff->name }}</li>
            @endforeach
        </ul>
    </div>
</div>

<!-- Applicants modal -->
<div id="applicants-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg p-6 w-1/2">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">เลือกผู้เข้าสอบ</h3>
            <button id="close-applicants-modal-btn" class="text-red-500">&times;</button>
        </div>
        <div id="applicant-list" class="max-h-64 overflow-y-auto">
            <!-- Applicant list will be populated here -->
        </div>
        <div class="flex justify-end mt-4">
            <button id="save-applicant-to-seat-btn" class="px-5 py-2 bg-blue-500 text-white rounded">บันทึก</button>
        </div>
    </div>
</div>

<script>
let validSeatCount = {{ $room->valid_seat }};
const roomId = {{ $room->id }};
let applicants = {!! json_encode($applicants) !!};
let seats = {!! json_encode($seats) !!};
let currentSeatId = '';

console.log('Applicants:', applicants);
console.log('Seats:', seats);

function toExcelColumn(n) {
    let result = '';
    while (n >= 0) {
        result = String.fromCharCode((n % 26) + 65) + result;
        n = Math.floor(n / 26) - 1;
    }
    return result;
}

function addSeats() {
    const rows = parseInt(document.getElementById('row-count').textContent);
    const columns = parseInt(document.getElementById('column-count').textContent);
    const seatContainer = document.getElementById('seat-container');
    seatContainer.innerHTML = '';
    seatContainer.style.gridTemplateColumns = `repeat(${columns}, minmax(4rem, 1fr))`;

    let seatComponents = '';
    let assignedSeats = 0;

    for (let i = 0; i < rows; i++) {
        for (let j = 0; j < columns; j++) {
            const seatId = `${i + 1}-${toExcelColumn(j)}`;
            let seatComponent = '';
            const seat = seats.find(seat => seat.row === (i + 1) && seat.column === (j + 1));
            const applicant = seat ? applicants.find(applicant => applicant.id === seat.applicant_id) : null;

            if (seat) {
                if (applicant) {
                    seatComponent = `
                        <div id="seat-${seatId}" class="seat p-4 text-center cursor-pointer" onclick="showApplicantModal('${seatId}', ${seat.id}, true)">
                            <x-seats.assigned applicant="${applicant.id_number}">
                                ${seatId}
                            </x-seats.assigned>
                        </div>
                    `;
                    assignedSeats++; 
                } else {
                    seatComponent = `
                        <div id="seat-${seatId}" class="seat p-4 text-center cursor-pointer" onclick="showApplicantModal('${seatId}', null, false)">
                            <x-seats.primary>
                                ${seatId}
                            </x-seats.primary>
                        </div>
                    `;
                }
            } else {
                seatComponent = `
                    <div id="seat-${seatId}" class="seat p-4 text-center cursor-pointer" onclick="showApplicantModal('${seatId}', null, false)">
                        <x-seats.primary>
                            ${seatId}
                        </x-seats.primary>
                    </div>
                `;
            }
            seatComponents += seatComponent;
        }
    }
    validSeatCount = {{ $room->total_seat }} - assignedSeats; 
    seatContainer.innerHTML = seatComponents;
    updateValidSeatCountUI(validSeatCount);
    updateValidSeatCountInDB(validSeatCount);
}

function updateValidSeatCountUI(validSeatCount) {
    document.getElementById('validSeatCount').textContent = validSeatCount;
}

document.addEventListener('DOMContentLoaded', addSeats);

document.getElementById('select-examiners-btn').addEventListener('click', function() {
    document.getElementById('examiners-modal').classList.remove('hidden');
    loadStaffs();
});

document.getElementById('close-modal-btn').addEventListener('click', function() {
    document.getElementById('examiners-modal').classList.add('hidden');
});

document.getElementById('save-examiners-btn').addEventListener('click', function() {
    const selectedExaminers = Array.from(document.querySelectorAll('.staff-checkbox:checked')).map(checkbox => {
        return {
            id: checkbox.value,
            name: checkbox.dataset.name
        };
    });

    const selectedExaminersList = document.getElementById('selected-examiners-list');
    selectedExaminersList.innerHTML = '';

    selectedExaminers.forEach(examiner => {
        const li = document.createElement('li');
        li.textContent = examiner.name;
        selectedExaminersList.appendChild(li);
    });

    saveStaffs(selectedExaminers);
    document.getElementById('examiners-modal').classList.add('hidden');
});

document.getElementById('close-applicants-modal-btn').addEventListener('click', function() {
    document.getElementById('applicants-modal').classList.add('hidden');
});

document.getElementById('save-applicant-to-seat-btn').addEventListener('click', function() {
    const selectedApplicant = document.querySelector('.applicant-radio:checked');
    if (selectedApplicant) {
        const applicantId = selectedApplicant.value;
        saveApplicantToSeat(currentSeatId, applicantId);
    }
    document.getElementById('applicants-modal').classList.add('hidden');
});

function loadStaffs() {
    fetch('/staffs')
        .then(response => response.json())
        .then(staffs => {
            const staffList = document.getElementById('staff-list');
            staffList.innerHTML = '';

            staffs.forEach(staff => {
                const div = document.createElement('div');
                div.classList.add('flex', 'items-center', 'gap-2', 'mb-2', 'staff-item');
                div.innerHTML = `
                    <input type="checkbox" value="${staff.id}" class="staff-checkbox" data-name="${staff.name}">
                    <p>${staff.name}</p>
                `;
                staffList.appendChild(div);
            });
        });
}

function saveStaffs(selectedExaminers) {
    fetch('/save-staffs', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            room_id: roomId,
            examiners: selectedExaminers
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Staff saved successfully.');
        } else {
            console.error('Server response:', data);
            alert('Failed to save staff.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while saving staff.');
    });
}

function showApplicantModal(seatId, seatRecordId, hasApplicant) {
    currentSeatId = seatId;

    const applicantList = document.getElementById('applicant-list');
    applicantList.innerHTML = '';

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
        const removeButton = document.createElement('button');
        removeButton.textContent = 'Remove Applicant';
        removeButton.classList.add('px-4', 'py-2', 'bg-red-500', 'text-white', 'rounded', 'mt-4');
        removeButton.onclick = () => removeApplicantFromSeat(seatRecordId);
        applicantList.appendChild(removeButton);
    } else {
        fetchApplicantsWithoutSeats();
    }

    document.getElementById('applicants-modal').classList.remove('hidden');
}

function saveApplicantToSeat(seatId, applicantId) {
    console.log('Saving applicant to seat:', { seatId, applicantId, roomId });
    fetch(`/save-applicant-to-seat`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            seat_id: seatId,
            applicant_id: applicantId,
            room_id: roomId
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Save applicant response:', data);
        if (data.success) {
            validSeatCount--;
            updateValidSeatCountUI(validSeatCount);
            updateValidSeatCountInDB(validSeatCount);
            location.reload();
            alert('Applicant assigned to seat successfully.');
        } else {
            console.error('Server response:', data);
            alert('Failed to assign applicant to seat.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while assigning applicant to seat.');
    });
}


function removeApplicantFromSeat(seatId) {
    console.log('Removing applicant from seat:', { seatId: seatId, roomId });
    fetch(`/remove-applicant-from-seat`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            seat_id: seatId,
            room_id: roomId
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Remove applicant response:', data);
        if (data.success) {
            validSeatCount++;
            updateValidSeatCountUI(validSeatCount);
            updateValidSeatCountInDB(validSeatCount);
            location.reload();
            alert('Applicant removed from seat successfully.');
        } else {
            console.error('Server response:', data);
            alert('Failed to remove applicant from seat.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while removing applicant from seat.');
    });
}

function fetchApplicantsWithoutSeats() {
    console.log('Fetching applicants without seats for room:', roomId);
    fetch(`/get-applicants-without-seats/${roomId}`)
        .then(response => {
            console.log('Fetch response:', response);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(applicantsWithoutSeats => {
            console.log('Applicants without seats:', applicantsWithoutSeats);
            const applicantList = document.getElementById('applicant-list');
            applicantList.innerHTML = '';

            applicantsWithoutSeats.forEach(applicant => {
                const div = document.createElement('div');
                div.classList.add('flex', 'items-center', 'gap-2', 'mb-2', 'applicant-item');
                div.innerHTML = `
                    <input type="radio" name="applicant" value="${applicant.id}" class="applicant-radio">
                    <p>${applicant.name}</p>
                `;
                applicantList.appendChild(div);
            });
        })
        .catch(error => {
            console.error('Error fetching applicants without seats:', error);
            alert('An error occurred while fetching applicants.');
        });
}
function updateValidSeatCountInDB(validSeatCount) {
    fetch(`/update-valid-seat-count`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            room_id: roomId,
            valid_seat_count: validSeatCount
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Valid seat count updated successfully in the database.');
        } else {
            console.error('Failed to update valid seat count in the database.', data);
        }
    })
    .catch(error => {
        console.error('Error updating valid seat count in the database:', error);
    });
}

</script>
@endsection