
@extends('layouts.main')

@section('content')
@php
    $applicantExamsArray = json_decode(json_encode($applicantExams), true);
    $groupedApplicants = collect($applicantExams)->groupBy('exam_id')->map(function ($group) use ($applicants) {
        return $group->map(function ($exam) use ($applicants) {
            return $applicants->firstWhere('id', $exam->applicant_id);
        });
    });

    // Assign colors to exam groups
    $colors = ['bg-green-500', 'bg-blue-500', 'bg-purple-500', 'bg-pink-500'];
    $examColors = [];
    foreach ($groupedApplicants as $examId => $group) {
        $examColors[$examId] = $colors[count($examColors) % count($colors)];
    }

    // Log::info('Grouped Applicants:', ['groupedApplicants' => $groupedApplicants]);
    // Log::info('Exam Colors:', ['examColors' => $examColors]);
@endphp
<div class="flex flex-col w-full max-h-full">
    <div class="flex justify-between">
        <div class="flex flex-col bg-white rounded-lg px-4 py-3 shadow-md overflow-y-auto max-h-32 mb-3">
            <div class="flex">
                <p class="font-semibold align-baseline text-2xl">
                    {{ $room->room }}
                </p>
                <p class="font-normal text-md ml-4 mt-1.5"> ชั้น </p>
                <p class="font-bold ml-1 mt-1.5"> {{ $room->floor }}</p>
                <p class="font-normal text- justify-start ml-4 mt-1.5"> ที่นั่งว่าง </p>
                <p id="validSeatCount" class="font-bold ml-1 mt-1.5 text-green-800"> {{ $room->valid_seat }}</p>
                <p class="font-normal text- justify-start ml-4 mt-1.5"> ที่นั่งทั้งหมด </p>
                <p id="totalSeatCount" class="font-bold ml-1 mt-1.5"> {{ $room->valid_seat }}</p>
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
                    @php
                        //Log::info('Processing position:', ['position' => $position]);

                        // Find the applicant exam entry for the position
                        $applicantExam = $applicantExams->first(function ($exam) use ($position, $applicants) {
                            $applicant = $applicants->firstWhere('id', $exam->applicant_id);
                            return $applicant && $applicant->position === $position;
                        });

                        // Check for null before accessing properties
                        if ($applicantExam) {
                            $examId = $applicantExam->exam_id ?? null;
                        } else {
                            $examId = null;
                        }

                        //Log::info('Position and Applicant Exam:', ['position' => $position, 'applicantExam' => $applicantExam, 'examId' => $examId]);

                        // Determine the color class
                        $colorClass = $examColors[$examId] ?? 'bg-gray-500';
                        
                        //Log::info('Exam ID and Color Assignment:', ['examId' => $examId, 'color' => $colorClass]);
                        $index = $loop->index;
                        $colorCount = floor($loop->index / 4);
                    @endphp
                    <span class="flex">ตำแหน่ง
                        <div class="w-4 h-4 ml-1 border-2 border-black translate-y-1 rounded-full {{ $colorClass }}">
                            @if($colorCount > 0)
                                <span class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 -mt-px -ml-0.5 text-white text-xs">{{ $colorCount }}</span>
                            @endif
                        </div>
                        <p class="ml-1 font-bold">{{ $position }}</p>@if(!$loop->last)@endif</span>
                    @endforeach
                </div>
                <div class="mr-4">
                    <span class="flex">
                    @foreach($departments as $department)
                        <p class="ml-1 font-semibold">( {{ $department }} )</p>@if(!$loop->last)@endif</span>
                    @endforeach
                </div>
                <div class="mr-4">
                    <span class="flex">
                    @foreach($subjects as $subject)
                        <p class="ml-1 font-semibold">( {{ $subject }} )</p>@if(!$loop->last)@endif</span>
                    @endforeach
                </div>
            </div>
            <div class="flex flex-wrap">
                เลขประจำตัวสอบสำหรับกลุ่ม
                @php
                    $groupedApplicants = collect($applicantExams)->groupBy('exam_id')->map(function ($group) use ($applicants) {
                        return $group->map(function ($exam) use ($applicants) {
                            return $applicants->firstWhere('id', $exam->applicant_id);
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
        <div class="flex gap-2 items-end my-2.5">
            <x-buttons.icon-primary type="button" class="px-[5px] pt-1.5 pb-1 z-40 translate-y-0.5" id="update-applicants-button">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 -translate-y-1" id="Outline" viewBox="0 0 24 24" width="512" height="512"><path d="M9.878,18.122a3,3,0,0,0,4.244,0l3.211-3.211A1,1,0,0,0,15.919,13.5l-2.926,2.927L13,1a1,1,0,0,0-1-1h0a1,1,0,0,0-1,1l-.009,15.408L8.081,13.5a1,1,0,0,0-1.414,1.415Z"/><path d="M23,16h0a1,1,0,0,0-1,1v4a1,1,0,0,1-1,1H3a1,1,0,0,1-1-1V17a1,1,0,0,0-1-1H1a1,1,0,0,0-1,1v4a3,3,0,0,0,3,3H21a3,3,0,0,0,3-3V17A1,1,0,0,0,23,16Z"/></svg>
                <x-tooltip title="ดาวน์โหลดผังห้อง" class="group-hover:-translate-x-10 group-hover:translate-y-0.5"></x-tooltip>
            </x-buttons.icon-primary>
            <x-buttons.icon-danger type="button" onclick="removeApplicantsFromRoom('{{ $selectedRooms->id }}')" class="px-[5px] pt-1.5 pb-1 z-40 translate-y-0.5">
                <svg id="Layer_1" height="24" class="w-6 h-6 translate-x-0.5 -translate-y-1" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><path d="m17 24a1 1 0 0 1 -1-1 7 7 0 0 0 -14 0 1 1 0 0 1 -2 0 9 9 0 0 1 18 0 1 1 0 0 1 -1 1zm6-11h-6a1 1 0 0 1 0-2h6a1 1 0 0 1 0 2zm-14-1a6 6 0 1 1 6-6 6.006 6.006 0 0 1 -6 6zm0-10a4 4 0 1 0 4 4 4 4 0 0 0 -4-4z"/></svg>
                <x-tooltip title="ลบผู้เข้าสอบออกจากที่นั่ง" class="group-hover:-translate-x-14 group-hover:translate-y-0.5"></x-tooltip>
            </x-buttons.icon-danger>
            <div x-data="{ showApplicantAdd: false }" class="z-40 translate-y-1">
                <x-buttons.icon-primary  @click="showApplicantAdd = !showApplicantAdd" id="applicant-add" onclick="event.stopPropagation();" type="button" class="px-[5px] pt-1.5 pb-1 z-40">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 translate-x-0.5 -translate-y-0.5" id="Outline" viewBox="0 0 24 24" width="24" height="24"><path d="M23,11H21V9a1,1,0,0,0-2,0v2H17a1,1,0,0,0,0,2h2v2a1,1,0,0,0,2,0V13h2a1,1,0,0,0,0-2Z"/><path d="M9,12A6,6,0,1,0,3,6,6.006,6.006,0,0,0,9,12ZM9,2A4,4,0,1,1,5,6,4,4,0,0,1,9,2Z"/><path d="M9,14a9.01,9.01,0,0,0-9,9,1,1,0,0,0,2,0,7,7,0,0,1,14,0,1,1,0,0,0,2,0A9.01,9.01,0,0,0,9,14Z"/></svg>
                    <x-tooltip title="เพิ่มผู้เข้าสอบลงที่นั่ง" class="group-hover:-translate-x-10 group-hover:translate-y-0.5"></x-tooltip>
                </x-buttons.icon-primary>
                @include('components.dropdowns.exam-room-detail.applicant-add')
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
let TotalSeat = {{$selectedRooms->room->valid_seat}}
const roomId = {{ $selectedRooms->room->id }};
const examId = {{ $exam->id }};
const exam = {!! json_encode($exam) !!};
let applicants = {!! json_encode($applicants) !!};
let applicantExams = {!! json_encode($applicantExams) !!};
let seats = {!! json_encode($seats) !!};
let invalidSeats = {!! json_encode($selectedRooms->room->invalid_seats) !!};
let currentSeatId = '';

//console.log('Applicants:', applicants);
//console.log('Seats:', seats);
//console.log('Exams;', exam)

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

    for (let i = 0; i < rows; i++) {
        for (let j = 0; j < columns; j++) {
            const seatId = `${i + 1}-${toExcelColumn(j)}`;
            let seatComponent = '';
            const seat = seats.find(seat => seat.row === (i + 1) && seat.column === (j + 1));
            const applicant = seat ? applicants.find(applicant => applicant.id === seat.applicant_id) : null;
            const examStatus = exam.status;

            if (invalidSeats && invalidSeats.includes(seatId)) {
                if (seat && applicant && ['inprogress', 'finished', 'unfinished'].includes(examStatus)) {
                    // Don't replace the applicant seat if exam status is inprogress, finished, or unfinished
                    const applicantExam = applicantExams.find(ae => ae.applicant_id === applicant.id);
                    const bgColor = applicantExam ? examGroups[applicantExam.exam_id] : 'bg-gray-500';
                    const colorIndex = Object.keys(examGroups).indexOf(applicantExam.exam_id.toString()) % colors.length;
                    let colorCount = (Math.floor(Object.keys(examGroups).indexOf(applicantExam.exam_id.toString()) / colors.length) + 1) - 1;

                    if (colorCount === 0) {
                        colorCount = '';
                    }

                    seatComponent = `
                        <div id="seat-${seatId}" class="seat p-4 text-center cursor-pointer" onclick="showApplicantModal('${seatId}', ${seat.id}, true)">
                            <x-seats.assigned :bgColor="'${bgColor}'" applicant="${applicant.id_number}" colorCount="${colorCount}">
                                ${seatId}
                            </x-seats.assigned>
                        </div>
                    `;
                    assignedSeats++;
                } else {
                    // Show deactivated seat if no applicant is assigned or exam status allows
                    seatComponent = `
                        <div id="seat-${seatId}" class="seat p-4 text-center">
                            <x-seats.unavailable slot="${seatId}">
                                ${seatId}
                            </x-seats.unavailable>
                        </div>
                    `;
                }
            } else if (seat) {
                if (applicant) {
                    const applicantExam = applicantExams.find(ae => ae.applicant_id === applicant.id);
                    const bgColor = applicantExam ? examGroups[applicantExam.exam_id] : 'bg-gray-500';
                    const colorIndex = Object.keys(examGroups).indexOf(applicantExam.exam_id.toString()) % colors.length;
                    let colorCount = (Math.floor(Object.keys(examGroups).indexOf(applicantExam.exam_id.toString()) / colors.length) + 1) - 1;

                    if (colorCount === 0) {
                        colorCount = '';
                    }

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
                            <label class="flex items-center w-full px-3 py-1.5 cursor-pointer transition-all duration-300 hover:bg-gray-200 rounded-md peer-disabled:cursor-not-allowed">
                                <div class="grid mr-3 place-items-center">
                                    <div class="inline-flex items-center">
                                        <label for="staff-${staff.id}" class="relative flex items-center p-0 rounded-sm cursor-pointer">
                                            <input id="staff-${staff.id}" type="checkbox" value="${staff.id}" data-name="${staff.name}" ${isAlreadySelected ? 'checked' : ''} ${isAssigned ? 'disabled' : ''}
                                                class="staff-checkbox peer relative h-5 w-5 cursor-pointer appearance-none rounded-sm border-2 border-gray-800 transition-all checked:border-gray-900 hover:bg-gray-200 disabled:bg-gray-300 disabled:cursor-not-allowed disabled:border-gray-300" />
                                            <span class="absolute text-gray-900 transition-opacity opacity-0 pointer-events-none top-2/4 left-2/4 -translate-y-2/4 -translate-x-2/4 peer-checked:opacity-100 peer-disabled:opacity-10">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 16 16" fill="currentColor">
                                                    <rect x="0" y="0" width="32" height="32"></rect>
                                                </svg>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <p class="block font-sans text-base antialiased font-medium leading-relaxed text-gray-900 peer-disabled:text-gray-300">
                                    ${staff.name}
                                </p>
                            </label>
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


function saveApplicantToSeat(seatId, applicantId, roomId, examId) {
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
            alert('Applicant assigned to seat successfully.');
            location.reload();
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

document.getElementById('save-applicant-to-seat-btn').addEventListener('click', function() {
    const selectedApplicant = document.querySelector('input[name="applicant"]:checked');
    if (selectedApplicant) {
        saveApplicantToSeat(currentSeatId, selectedApplicant.value, roomId, examId);
        document.getElementById('applicants-modal').classList.add('hidden');
    } else {
        alert('Please select an applicant.');
    }
});

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
            alert(data.message);
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

function removeApplicantsFromRoom(selected_room_id) {
    console.log('Removing applicants from room:', selected_room_id);
    fetch(`/remove-applicants-from-room`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure this is correctly set in your Blade template
        },
        body: JSON.stringify({
            selectedRoom_id: selected_room_id,
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Remove applicants response:', data);
        if (data.success) {
            alert('Applicants removed from room successfully.');
            location.reload(); // Reload the page to reflect the changes
        } else {
            console.error('Server response:', data);
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while removing applicants from room.');
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


function assignAllApplicantsToSeats(direction) {
    const examId = {{ $exam->id }};
    const roomId = {{ $selectedRooms->room->id }};

    fetch('/assign-all-applicants-to-seats', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            exam_id: examId,
            room_id: roomId,
            direction: direction
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while assigning applicants to seats.');
    });
}


</script>
@endsection
