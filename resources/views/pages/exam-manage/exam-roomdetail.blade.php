@extends('layouts.main')

@section('content')
<div class="flex flex-col w-full max-h-full">
    <div class="flex justify-between items-center">
        <div class="flex">
            <p class="font-semibold align-baseline text-2xl">
                {{ $selectedRooms->room->room }}
            </p>
            {{-- <p class="font-normal text-md ml-4 mt-1.5"> ชั้น </p>
            <p class="font-bold ml-1 mt-1.5"> {{ $room->floor }}</p> --}}
            <p class="font-normal text- justify-start ml-4 mt-1.5"> ที่นั่งว่าง </p>
            <p id="validSeatCount" class="font-bold ml-1 mt-1.5 text-green-800"> {{ $selectedRooms->room->valid_seat }}</p>
            <p class="font-normal text- justify-start ml-4 mt-1.5"> ที่นั่งทั้งหมด </p>
            <p id="totalSeatCount" class="font-bold ml-1 mt-1.5"> {{ $selectedRooms->room->total_seat }}</p>
            <p class="font-normal text- justify-start ml-4 mt-1.5"> แถว </p>
            <p id="row-count" class="font-bold ml-1 mt-1.5 text-black"> {{ $selectedRooms->room->rows }}</p>
            <p class="font-normal text- justify-start ml-4 mt-1.5"> คอลัมน์ </p>
            <p id="column-count" class="font-bold ml-1 mt-1.5 text-black"> {{ $selectedRooms->room->columns }}</p>
        </div>
        <div class="flex">
            <x-buttons.primary id="select-examiners-btn" class="px-5 py-2 rounded-lg bg-blue-500 text-white">
                เลือกผู้คุมสอบ
            </x-buttons.primary>
        </div>
    </div>
    <div>
        ชั้น: {{$room->floor}} , ชื่อห้อง: {{$room->room}} , ชื่อตึก: {{ $building->building_th}}
    </div>
    <div class="flex flex-wrap my-4">
        <div class="mr-4">
            ชื่อฝ่ายงาน:
            @foreach($departments as $department)
                <span>{{ $department }}@if(!$loop->last),@endif</span>
            @endforeach
        </div>
        <div>
            ชื่อตำแหน่งสอบ:
            @foreach($positions as $position)
                <span>{{ $position }}@if(!$loop->last),@endif</span>
            @endforeach
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
            <h3 class="text-xl font-semibold"></h3>
            <button id="close-applicants-modal-btn" class="text-red-500">&times;</button>
        </div>
        <div id="applicant-info" class="mb-4 hidden">
            <!-- Applicant info will be displayed here -->
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
let validSeatCount = {{ $selectedRooms->room->valid_seat }};
const roomId = {{ $selectedRooms->room->id }};
const examId = {{ $exam->id }};
let applicants = {!! json_encode($applicants) !!};
let applicantExams = {!! json_encode($applicantExams) !!};
let seats = {!! json_encode($seats) !!};
let currentSeatId = '';

//console.log('Applicants:', applicants);
//console.log('Seats:', seats);

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
    
    const colors = ['bg-green-500', 'bg-blue-500', 'bg-red-500', 'bg-yellow-500'];
    let examGroups = {}; 

    applicantExams.forEach((applicantExam) => {
        if (!examGroups[applicantExam.exam_id]) {
            examGroups[applicantExam.exam_id] = colors[Object.keys(examGroups).length % colors.length];
        }
    });
    //console.log('Exam Groups:', examGroups);
    for (let i = 0; i < rows; i++) {
        for (let j = 0; j < columns; j++) {
            const seatId = `${i + 1}-${toExcelColumn(j)}`;
            let seatComponent = '';
            const seat = seats.find(seat => seat.row === (i + 1) && seat.column === (j + 1));
            const applicant = seat ? applicants.find(applicant => applicant.id === seat.applicant_id) : null;

            if (seat) {
                if (applicant) {
                    const applicantExam = applicantExams.find(ae => ae.applicant_id === applicant.id);
                    const bgColor = applicantExam ? examGroups[applicantExam.exam_id] : 'bg-gray-500';
                    seatComponent = `
                        <div id="seat-${seatId}" class="seat p-4 text-center cursor-pointer" onclick="showApplicantModal('${seatId}', ${seat.id}, true)">
                            <x-seats.assigned :bgColor="'${bgColor}'" applicant="${applicant.id_number}">
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
    validSeatCount = assignedSeats; 
    seatContainer.innerHTML = seatComponents;
    updateValidSeatCountUI(validSeatCount);
    updateValidSeatCountInDB(validSeatCount);
}

function updateValidSeatCountUI(validSeatCount) {
    document.getElementById('validSeatCount').textContent = validSeatCount;
}

document.addEventListener('DOMContentLoaded', addSeats);

document.addEventListener('DOMContentLoaded', function() {
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

        saveStaffs(selectedExaminers);
    });

    function loadStaffs() {
        fetch('/staffs')
            .then(response => response.json())
            .then(staffs => {
                let allStaffs = staffs;

                const selectedStaffIds = {!! json_encode($staffs->pluck('id')) !!};
                const assignedStaffs = {!! json_encode($assignedStaffs) !!};

                console.log('Assigned Staffs:', assignedStaffs);

                const examStartTimeStr = '{{ $exam->exam_date }} {{ $exam->exam_start_time }}';
                const examEndTimeStr = '{{ $exam->exam_date }} {{ $exam->exam_end_time }}';

                console.log('Exam Start Time:', examStartTimeStr);
                console.log('Exam End Time:', examEndTimeStr);

                function renderStaffList(staffs) {
                    const staffList = document.getElementById('staff-list');
                    staffList.innerHTML = '';

                    staffs.forEach(staff => {
                        let isAssigned = false;
                        let isAlreadySelected = selectedStaffIds.includes(staff.id);

                        assignedStaffs.forEach(assignment => {
                            if (assignment.staff_id === staff.id) {
                                const staffStartTimeStr = assignment.exam_date + ' ' + assignment.exam_start_time;
                                const staffEndTimeStr = assignment.exam_date + ' ' + assignment.exam_end_time;

                                console.log(`Checking staff ${staff.name} (${staff.id}) against exam times.`);
                                console.log(`Staff Start: ${staffStartTimeStr}, Staff End: ${staffEndTimeStr}`);

                                if ((examStartTimeStr < staffEndTimeStr && examEndTimeStr > staffStartTimeStr) || 
                                    (examStartTimeStr < staffEndTimeStr && examEndTimeStr >= staffEndTimeStr) || 
                                    (examStartTimeStr <= staffStartTimeStr && examEndTimeStr > staffStartTimeStr)) {
                                    console.log(`Time overlap detected for staff ${staff.name} (${staff.id}).`);
                                    
                                    if ((assignment.exam_id !== examId || assignment.room_id !== roomId) && !isAlreadySelected) {
                                        isAssigned = true;
                                        console.log(`Staff ${staff.name} (${staff.id}) is assigned: ${isAssigned} due to different room or exam.`);
                                    }
                                }
                            }
                        });

                        console.log(`Final assignment status for staff ${staff.name} (${staff.id}): ${isAssigned}`);
                        const div = document.createElement('div');
                        div.classList.add('flex', 'items-center', 'gap-2', 'mb-2', 'staff-item');
                        div.innerHTML = `
                            <input type="checkbox" value="${staff.id}" class="staff-checkbox" data-name="${staff.name}" ${isAlreadySelected ? 'checked' : ''} ${isAssigned ? 'disabled' : ''}>
                            <p>${staff.name}</p>
                        `;
                        staffList.appendChild(div);
                    });

                    // Add event listeners to checkboxes for deselection logic
                    document.querySelectorAll('.staff-checkbox').forEach(checkbox => {
                        checkbox.addEventListener('change', function() {
                            if (checkbox.checked) {
                                selectedStaffIds.push(parseInt(checkbox.value));
                            } else {
                                const index = selectedStaffIds.indexOf(parseInt(checkbox.value));
                                if (index > -1) {
                                    selectedStaffIds.splice(index, 1);
                                }
                            }
                        });
                    });
                }

                renderStaffList(allStaffs);

                document.getElementById('search-staff-input').addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const filteredStaffs = allStaffs.filter(staff => staff.name.toLowerCase().includes(searchTerm));
                    renderStaffList(filteredStaffs);
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
                exam_id: examId,
                examiners: selectedExaminers
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const selectedExaminersList = document.getElementById('selected-examiners-list');
                selectedExaminersList.innerHTML = '';

                if (Array.isArray(data.staffs)) {
                    data.staffs.forEach(examiner => {
                        const li = document.createElement('li');
                        li.textContent = examiner.name;
                        selectedExaminersList.appendChild(li);
                    });
                }

                alert('Staff saved successfully.');
                document.getElementById('examiners-modal').classList.add('hidden');
                location.reload();
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
});

function showApplicantModal(seatId, seatRecordId, hasApplicant, examId) {
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

document.getElementById('save-applicant-to-seat-btn').addEventListener('click', function() {
    const selectedApplicant = document.querySelector('input[name="applicant"]:checked');
    if (selectedApplicant) {
        saveApplicantToSeat(currentSeatId, selectedApplicant.value, examId);
        document.getElementById('applicants-modal').classList.add('hidden');
    } else {
        alert('Please select an applicant.');
    }
});

function saveApplicantToSeat(seatId, applicantId, examId) {
    console.log('Saving applicant to seat:', { seatId, applicantId, roomId, examId });
    fetch(`/save-applicant-to-seat`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            seat_id: seatId,
            applicant_id: applicantId,
            room_id: roomId,
            exam_id: examId 
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
            alert('Failed to assign applicant to seat: ' + data.message);
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
    console.log('Fetching applicants without seats for room:', roomId, 'and exam:', examId);
    fetch(`/get-applicants-without-seats/${examId}/${roomId}`)
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
            exam_id: examId,
            valid_seat_count: validSeatCount
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            //console.log('Valid seat count updated successfully in the database.');
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