
@extends('layouts.main')

@section('content')
<div class="flex flex-col w-full max-h-full">
    <div class="flex justify-between items-center">
        <div class="flex flex-col bg-white rounded-lg px-4 py-3 shadow-md overflow-y-auto max-h-32 mb-3">
            <div class="flex">
                <p class="font-semibold align-baseline text-2xl">
                    {{ $room->room }}
                </p>
                {{-- <p class="font-normal text-md ml-4 mt-1.5"> ชั้น </p>
                <p class="font-bold ml-1 mt-1.5"> {{ $room->floor }}</p> --}}
                <p class="font-normal text- justify-start ml-4 mt-1.5"> ที่นั่งว่าง </p>
                <p id="validSeatCount" class="font-bold ml-1 mt-1.5 text-green-800"> {{ $room->valid_seat }}</p>
                <p class="font-normal text- justify-start ml-4 mt-1.5"> ที่นั่งทั้งหมด </p>
                <p id="totalSeatCount" class="font-bold ml-1 mt-1.5"> {{ $room->total_seat }}</p>
                <p class="font-normal text- justify-start ml-4 mt-1.5"> แถว </p>
                <p id="row-count" class="font-bold ml-1 mt-1.5 text-black"> {{ $room->rows }}</p>
                <p class="font-normal text- justify-start ml-4 mt-1.5"> คอลัมน์ </p>
                <p id="column-count" class="font-bold ml-1 mt-1.5 text-black"> {{ $room->columns }}</p>
                <p class="font-normal text- justify-start ml-4 mt-1.5"> อาคาร </p>
                <p id="column-count" class="font-bold ml-1 mt-1.5 text-black"> {{ $room->building->building_th }}</p>
            </div>
            <div class="flex flex-wrap">
                <div>
                    @foreach($positions as $position)
                    <span class="flex">ตำแหน่ง
                            <div class=" w-4 h-4 ml-1 border-2 border-black translate-y-1 rounded-full bg-green-500"></div>
                            <p class="ml-1 font-bold">{{ $position }}</p>@if(!$loop->last)@endif</span>
                    @endforeach
                </div>
                <div class="mr-4">
                    <span class="flex">
                    @foreach($departments as $department)
                            <p class="ml-1 font-semibold">( {{ $department }} )</p>@if(!$loop->last)@endif</span>
                    @endforeach
                </div>

            </div>
            <div class="flex flex-wrap">
                เลขประจำตัวสอบสำหรับกลุ่ม
                @php
                    $applicantExamsArray = json_decode(json_encode($applicantExams), true);
                    $groupedApplicants = collect($applicantExamsArray)->groupBy('exam_id')->map(function ($group) use ($applicants) {
                        return $group->map(function ($exam) use ($applicants) {
                            return $applicants->firstWhere('id', $exam['applicant_id']);
                        });
                    });
                @endphp

                @foreach($groupedApplicants as $examId => $group)
                    @php
                        $idNumbers = $group->pluck('id_number')->sort();
                        $minIdNumber = $idNumbers->first();
                        $maxIdNumber = $idNumbers->last();
                    @endphp
                    <div>
                        , {{$examId}} :
                        <span>
                            @if($minIdNumber == $maxIdNumber)
                                {{ $minIdNumber }}
                            @else
                                {{ $minIdNumber }} - {{ $maxIdNumber }}
                            @endif
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="flex align-center gap-8">
            <div class="flex gap-4">
                <x-buttons.danger type="button" onclick="" class="pl-2 py-2 z-10 rounded-lg fill-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="translate-x-0.5" id="Outline" viewBox="0 0 24 24" width="24" height="24"><path d="M21,4H17.9A5.009,5.009,0,0,0,13,0H11A5.009,5.009,0,0,0,6.1,4H3A1,1,0,0,0,3,6H4V19a5.006,5.006,0,0,0,5,5h6a5.006,5.006,0,0,0,5-5V6h1a1,1,0,0,0,0-2ZM11,2h2a3.006,3.006,0,0,1,2.829,2H8.171A3.006,3.006,0,0,1,11,2Zm7,17a3,3,0,0,1-3,3H9a3,3,0,0,1-3-3V6H18Z"/><path d="M10,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,10,18Z"/><path d="M14,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,14,18Z"/></svg>
                    <x-tooltip title="ลบผู้เข้าสอบออกจากที่นั่ง" class="group-hover:-translate-x-[5.5rem] group-hover:translate-y-8"></x-tooltip>
                </x-buttons.danger>
                <x-buttons.primary type="button" onclick="" class="pl-2 py-2 z-10 rounded-lg fill-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="translate-x-1" id="Outline" viewBox="0 0 24 24" width="24" height="24"><path d="M23,11H21V9a1,1,0,0,0-2,0v2H17a1,1,0,0,0,0,2h2v2a1,1,0,0,0,2,0V13h2a1,1,0,0,0,0-2Z"/><path d="M9,12A6,6,0,1,0,3,6,6.006,6.006,0,0,0,9,12ZM9,2A4,4,0,1,1,5,6,4,4,0,0,1,9,2Z"/><path d="M9,14a9.01,9.01,0,0,0-9,9,1,1,0,0,0,2,0,7,7,0,0,1,14,0,1,1,0,0,0,2,0A9.01,9.01,0,0,0,9,14Z"/></svg>
                    <x-tooltip title="เพิ่มผู้เข้าสอบลงที่นั่ง" class="group-hover:-translate-x-20 group-hover:translate-y-8"></x-tooltip>
                </x-buttons.primary>
            </div>
            <x-buttons.primary id="select-examiners-btn" class="px-5 py-2 rounded-lg text-white">
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

<script>
let validSeatCount = {{ $selectedRooms->room->valid_seat }};
let TotalSeat = {{$selectedRooms->room->total_seat}}
const roomId = {{ $selectedRooms->room->id }};
const examId = {{ $exam->id }};
let applicants = {!! json_encode($applicants) !!};
let applicantExams = {!! json_encode($applicantExams) !!};
let seats = {!! json_encode($seats) !!};
let invalidSeats = {!! json_encode($selectedRooms->room->invalid_seats) !!};
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

    const colors = ['bg-green-500', 'bg-blue-500', 'bg-purple-500', 'bg-pink-500'];
    let examGroups = {};
    let colorCounters = {};

    applicantExams.forEach((applicantExam) => {
        if (!examGroups[applicantExam.exam_id]) {
            const colorIndex = Object.keys(examGroups).length % colors.length;
            examGroups[applicantExam.exam_id] = colors[colorIndex];
            if (!colorCounters[colors[colorIndex]]) {
                colorCounters[colors[colorIndex]] = 1;
            } else {
                colorCounters[colors[colorIndex]]++;
            }
        }
    });

    //console.log('Exam Groups:', examGroups);
    //console.log('Color Counters:', colorCounters);

    for (let i = 0; i < rows; i++) {
        for (let j = 0; j < columns; j++) {
            const seatId = `${i + 1}-${toExcelColumn(j)}`;
            let seatComponent = '';
            const seat = seats.find(seat => seat.row === (i + 1) && seat.column === (j + 1));
            const applicant = seat ? applicants.find(applicant => applicant.id === seat.applicant_id) : null;

            if (invalidSeats && invalidSeats.includes(seatId)) {
                seatComponent = `
                    <div id="seat-${seatId}" class="seat p-4 text-center cursor-not-allowed">
                        <x-seats.unavailable slot="${seatId}" />
                    </div>
                `;
            } else if (seat) {
                if (applicant) {
                    const applicantExam = applicantExams.find(ae => ae.applicant_id === applicant.id);
                    const bgColor = applicantExam ? examGroups[applicantExam.exam_id] : 'bg-gray-500';
                    const colorIndex = Object.keys(examGroups).indexOf(applicantExam.exam_id.toString()) % colors.length;
                    let colorCount = (Math.floor(Object.keys(examGroups).indexOf(applicantExam.exam_id.toString()) / colors.length) + 1) - 1;

                    if (colorCount === 0) {
                        colorCount = '';
                    }

                    //console.log('Applicant:', applicant.id_number, 'Color:', bgColor, 'Color Count:', colorCount, 'Color Index:', colorIndex);

                    seatComponent = `
                        <div id="seat-${seatId}" class="seat p-4 text-center cursor-pointer" onclick="showApplicantModal('${seatId}', ${seat.id}, true)">
                            <x-seats.assigned :bgColor="'${bgColor}'" applicant="${applicant.id_number}" colorCount="${colorCount}">
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
    validSeatCount = TotalSeat - assignedSeats;
    seatContainer.innerHTML = seatComponents;
    updateValidSeatCountUI(validSeatCount);
    // updateValidSeatCountInDB(validSeatCount);
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

                    let checkedStaffs = [];
                    let uncheckedStaffs = [];

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
<label class="flex items-center w-full px-3 py-1.5 cursor-pointer transition-all duration-300 hover:bg-gray-200 rounded-md">
                                <div class="grid mr-3 place-items-center">
                                    <div class="inline-flex items-center">
                                        <label for="staff-${ staff.id }" class="relative flex items-center p-0 rounded-full cursor-pointer">
                                            <input id="staff-${ staff.id }" type="radio" value="${staff.id}" data-name="${staff.name}" ${isAlreadySelected ? 'checked' : ''} ${isAssigned ? 'disabled' : ''}
                                                class="staff-checkbox before:content[''] peer relative h-5 w-5 cursor-pointer appearance-none rounded-full border border-gray-800 text-gray-900 transition-all before:absolute before:top-2/4 before:left-2/4 before:block before:h-12 before:w-12 before:-translate-y-2/4 before:-translate-x-2/4 before:rounded-full before:bg-blue-gray-00 before:opacity-0 before:transition-opacity checked:border-gray-900 checked:before:bg-gray-900 hover:before:opacity-0" />
                                            <span class="absolute text-gray-900 transition-opacity opacity-0 pointer-events-none top-2/4 left-2/4 -translate-y-2/4 -translate-x-2/4 peer-checked:opacity-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 16 16" fill="currentColor">
                                                    <circle data-name="ellipse" cx="8" cy="8" r="8"></circle>
                                                </svg>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <p class="block font-sans text-base antialiased font-medium leading-relaxed text-gray-900">
                                    ${staff.name}
                                </p>
                        `;

                        if (isAlreadySelected) {
                            checkedStaffs.push(div);
                        } else {
                            uncheckedStaffs.push(div);
                        }
                    });


                    document.querySelectorAll('.staff-checkbox').forEach(checkbox => {
                        checkbox.addEventListener('click', function() {
                            if (checkbox.checked) {
                                selectedStaffIds.push(parseInt(checkbox.value));
                                checkbox.checked = false;
                            } else {
                                const index = selectedStaffIds.indexOf(parseInt(checkbox.value));
                                if (index > -1) {
                                    selectedStaffIds.splice(index, 1);
                                }
                                checkbox.checked = true;
                            }

                            renderStaffList(allStaffs);
                        });
                    });
                    checkedStaffs.forEach(div => staffList.appendChild(div));
                    uncheckedStaffs.forEach(div => staffList.appendChild(div));
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
            // updateValidSeatCountInDB(validSeatCount);
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
            // updateValidSeatCountInDB(validSeatCount);
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

// function updateValidSeatCountInDB(validSeatCount) {
//     fetch(`/update-valid-seat-count`, {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//             'X-CSRF-TOKEN': '{{ csrf_token() }}'
//         },
//         body: JSON.stringify({
//             room_id: roomId,
//             exam_id: examId,
//             valid_seat_count: validSeatCount
//         })
//     })
//     .then(response => response.json())
//     .then(data => {
//         if (data.success) {
//             //console.log('Valid seat count updated successfully in the database.');
//         } else {
//             console.error('Failed to update valid seat count in the database.', data);
//         }
//     })
//     .catch(error => {
//         console.error('Error updating valid seat count in the database:', error);
//     });
// }

</script>
@endsection
