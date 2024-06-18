@props([
    'href' => '#', 
    'exam_name' => 'null',
    'department_name' => 'null',
    'exam_position' => 'null',
    'exam_date' => 'null',
    'exam_start_time' => 'null',
    'exam_end_time' => 'null',
    'status' => 'null',
    'exam_id',
])

<div class="room-item relative flex bg-white flex-col bg-clip-border rounded-lg w-[260px] shadow-md mt-6 transition-all duration-500 hover:scale-105 hover:shadow-lg"">
    <a href="#" class="absolute inset-0 z-0"></a>
    <div class="px-4 py-3 text-surface text-black">
        <div class="group flex">
            <span class="relative group flex hover-trigger">
                <p class="text-xl my-1 font-semibold max-w-56 truncate">
                    {{ $exam_name }}
                </p>
                <x-tooltip title="{{ $exam_name }}" class="group-hover:translate-y-6 z-20"></x-tooltip>
            </span> 
        </div>
        <div class="my-2 flex">
            สถานะ: 
            @if ($status == 'pending')
            <p class="w-max ml-2 py-1 px-2 -translate-y-0.5 bg-gradient-to-tr from-yellow-600 to-yellow-400 rounded-lg text-sm text-white shadow-md">
                รอการเลือกห้องสอบ
            </p>
            @endif
            @if ($status == 'ready')
            <p class="w-max ml-2 py-1 px-2 -translate-y-0.5 bg-gradient-to-tr from-green-600 to-green-400 rounded-lg text-sm text-white shadow-md">
                พร้อมจัดสอบ
            </p>
            @endif
            @if ($status == 'inprogress')
            <p class="w-max ml-2 py-1 px-2 -translate-y-0.5 bg-gradient-to-tr from-cyan-600 to-cyan-400 rounded-lg text-sm text-white shadow-md">
                ระหว่างการสอบ
            </p>
            @endif
            @if ($status == 'finished')
            <p class="w-max ml-2 py-1 px-2 -translate-y-0.5 bg-gradient-to-tr from-gray-600 to-gray-400 rounded-lg text-sm text-white shadow-md">
                การสอบเสร็จสิ้น
            </p>
            @endif
        </div>
        <div class="flex">
            วันที่สอบ: {{ \Carbon\Carbon::parse($exam_start_time)->format('D, d/m/Y') }}
        </div>
        <div class="flex">
            เวลาสอบ: {{ \Carbon\Carbon::parse($exam_start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($exam_end_time)->format('H:i') }}
        </div>
        <div class="flex">
            ตำแหน่ง: {{ $exam_position }}
        </div>
        <div class="mb-2 mt-4 flex">
            จัดสอบโดย: {{ $department_name }}
        </div>
        <div class="flex justify-between pb-1 pt-3">
            <x-buttons.primary type="button" class="py-1.5 px-12 z-10"
                onclick="">
                เลือก
            </x-buttons.primary>
            <x-buttons.icon-info type="button" onclick="" class="px-1 py-1 z-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="" id="Outline" viewBox="0 0 24 24" width="20" height="20">
                    <path d="M22.853,1.148a3.626,3.626,0,0,0-5.124,0L1.465,17.412A4.968,4.968,0,0,0,0,20.947V23a1,1,0,0,0,1,1H3.053a4.966,4.966,0,0,0,3.535-1.464L22.853,6.271A3.626,3.626,0,0,0,22.853,1.148ZM5.174,21.122A3.022,3.022,0,0,1,3.053,22H2V20.947a2.98,2.98,0,0,1,.879-2.121L15.222,6.483l2.3,2.3ZM21.438,4.857,18.932,7.364l-2.3-2.295,2.507-2.507a1.623,1.623,0,1,1,2.295,2.3Z"/>
                </svg>
                <x-tooltip title="แก้ไขข้อมูล" class="group-hover:-translate-x-6"></x-tooltip>
            </x-buttons.icon-info>
            <x-buttons.icon-danger type="button" onclick="event.stopPropagation(); deleteExam('{{ $exam_id }}')" class="px-1 py-1 z-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="" id="Outline" viewBox="0 0 24 24" width="20" height="20"><path d="M21,4H17.9A5.009,5.009,0,0,0,13,0H11A5.009,5.009,0,0,0,6.1,4H3A1,1,0,0,0,3,6H4V19a5.006,5.006,0,0,0,5,5h6a5.006,5.006,0,0,0,5-5V6h1a1,1,0,0,0,0-2ZM11,2h2a3.006,3.006,0,0,1,2.829,2H8.171A3.006,3.006,0,0,1,11,2Zm7,17a3,3,0,0,1-3,3H9a3,3,0,0,1-3-3V6H18Z"/><path d="M10,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,10,18Z"/><path d="M14,18a1,1,0,0,0,1-1V11a1,1,0,0,0-2,0v6A1,1,0,0,0,14,18Z"/></svg>
                <x-tooltip title="ลบการสอบ" class="group-hover:-translate-x-6"></x-tooltip>
            </x-buttons.icon-danger>
        </div>
    </div>
</div>

<script>
    function deleteExam(examId) {
        if (confirm('Are you sure you want to delete this room?')) {
            fetch(`/exams/${examId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    alert('Exam deleted successfully.');
                    location.reload();
                } else {
                    alert('Failed to delete the room.');
                }
            });
        }
    }
</script>