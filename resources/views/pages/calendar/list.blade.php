@extends('layouts.main')

@section('content')
<div class="flex justify-between">
    <div id="calendar" class="w-full h-max px-8 pb-8 pt-6 my-3 bg-white rounded-lg shadow-md"></div>
    <div class="w-full ml-6 mr-2 my-3 max-h-screen overflow-y-auto">
        <div class="flex flex-col gap-4">
            <div class="bg-white rounded-lg shadow-md px-3 py-3 font-light">
                <div class="px-2 pt-1 fill-gray-500 text-gray-500 flex items-center gap-1.5"> 
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><path d="M13,2.051V1a1,1,0,0,0-2,0V2.051A10.98,10.98,0,0,0,3.681,20.176,3.024,3.024,0,0,0,2,23a1,1,0,0,0,2,0,1.2,1.2,0,0,1,1.11-1.229.932.932,0,0,0,.2-.062,10.924,10.924,0,0,0,13.39,0,1.033,1.033,0,0,0,.182.064A1.2,1.2,0,0,1,20,23a1,1,0,0,0,2,0,3.024,3.024,0,0,0-1.681-2.824A10.98,10.98,0,0,0,13,2.051ZM3,13a9,9,0,1,1,9,9A9.011,9.011,0,0,1,3,13Z"/><path d="M19.215,0a1,1,0,0,0,0,2A2.59,2.59,0,0,1,22,4.5a1,1,0,0,0,2,0A4.6,4.6,0,0,0,19.215,0Z"/><path d="M2,4.5A2.59,2.59,0,0,1,4.785,2a1,1,0,0,0,0-2A4.6,4.6,0,0,0,0,4.5a1,1,0,0,0,2,0Z"/><path d="M13,11.586V7a1,1,0,0,0-2,0v5a1,1,0,0,0,.293.707l3,3a1,1,0,0,0,1.414-1.414Z"/></svg>
                    <p>9.00</p>
                    <p>-</p>
                    <p>12.00</p>
                    <p class="w-max ml-2 py-1 px-2 -translate-y-0.5 bg-gradient-to-tr from-yellow-600 to-yellow-400 rounded-lg text-sm text-white shadow-md">
                        รอการเลือกห้องสอบ
                    </p>
                </div>
                <div class="px-2 pt-1 font-semibold text-2xl">
                    <p>เจ้าหน้าที่บริหารงานทั่วไประดับปฏิบัติการ</p>
                </div>
                <div class="px-2 pt-1 flex items-center gap-1.5">
                    <p id="department_name">งานบริหารระบบเอกสารกลาง,</p>
                    <p id="organization">สำนักกองบริหารกลาง</p>
                </div>
                <div class="px-2 pt-1 pb-1 fill-gray-500 text-gray-500 flex items-center gap-1.5"> 
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><path d="M12,12A4,4,0,1,0,8,8,4,4,0,0,0,12,12Zm0-6a2,2,0,1,1-2,2A2,2,0,0,1,12,6ZM16,22.03l8,1.948V13.483a3,3,0,0,0-2.133-2.871l-2.1-.7A8.037,8.037,0,0,0,20,8.006a8,8,0,0,0-16,0,8.111,8.111,0,0,0,.1,1.212A2.992,2.992,0,0,0,0,12v9.752l7.983,2.281ZM7.757,3.764a6,6,0,0,1,8.493,8.477L12,16.4,7.757,12.249a6,6,0,0,1,0-8.485ZM2,12a.985.985,0,0,1,.446-.832A1.007,1.007,0,0,1,3.43,11.1l1.434.518a8.036,8.036,0,0,0,1.487,2.056L12,19.2l5.657-5.533a8.032,8.032,0,0,0,1.4-1.882l2.217.741a1,1,0,0,1,.725.961v7.949L16,19.97l-7.98,2L2,20.246Z"/></svg>
                    <p>ศูนย์เรียนรวม 3</p>
                    <svg id="Layer_1" class="w-4 h-4 ml-2" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><path d="m23 14h-1v-9a5.006 5.006 0 0 0 -5-5h-10a5.006 5.006 0 0 0 -5 5v9h-1a1 1 0 0 0 0 2h10v4h-2a3 3 0 0 0 -3 3 1 1 0 0 0 2 0 1 1 0 0 1 1-1h6a1 1 0 0 1 1 1 1 1 0 0 0 2 0 3 3 0 0 0 -3-3h-2v-4h10a1 1 0 0 0 0-2zm-19-9a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v9h-16z"/></svg>
                    <p>213, 214</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md px-3 py-3 font-light">
                <div class="px-2 pt-1 fill-gray-500 text-gray-500 flex items-center gap-1.5"> 
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><path d="M13,2.051V1a1,1,0,0,0-2,0V2.051A10.98,10.98,0,0,0,3.681,20.176,3.024,3.024,0,0,0,2,23a1,1,0,0,0,2,0,1.2,1.2,0,0,1,1.11-1.229.932.932,0,0,0,.2-.062,10.924,10.924,0,0,0,13.39,0,1.033,1.033,0,0,0,.182.064A1.2,1.2,0,0,1,20,23a1,1,0,0,0,2,0,3.024,3.024,0,0,0-1.681-2.824A10.98,10.98,0,0,0,13,2.051ZM3,13a9,9,0,1,1,9,9A9.011,9.011,0,0,1,3,13Z"/><path d="M19.215,0a1,1,0,0,0,0,2A2.59,2.59,0,0,1,22,4.5a1,1,0,0,0,2,0A4.6,4.6,0,0,0,19.215,0Z"/><path d="M2,4.5A2.59,2.59,0,0,1,4.785,2a1,1,0,0,0,0-2A4.6,4.6,0,0,0,0,4.5a1,1,0,0,0,2,0Z"/><path d="M13,11.586V7a1,1,0,0,0-2,0v5a1,1,0,0,0,.293.707l3,3a1,1,0,0,0,1.414-1.414Z"/></svg>
                    <p>9.00</p>
                    <p>-</p>
                    <p>12.00</p>
                    <p class="w-max ml-2 py-1 px-2 -translate-y-0.5 bg-gradient-to-tr from-green-600 to-green-400 rounded-lg text-sm text-white shadow-md">
                        พร้อมจัดสอบ
                    </p>
                </div>
                <div class="px-2 pt-1 font-semibold text-2xl">
                    <p>เจ้าหน้าที่บริหารงานทั่วไประดับปฏิบัติการ</p>
                </div>
                <div class="px-2 pt-1 flex items-center gap-1.5">
                    <p id="department_name">งานบริหารระบบเอกสารกลาง,</p>
                    <p id="organization">สำนักกองบริหารกลาง</p>
                </div>
                <div class="px-2 pt-1 pb-1 fill-gray-500 text-gray-500 flex items-center gap-1.5"> 
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><path d="M12,12A4,4,0,1,0,8,8,4,4,0,0,0,12,12Zm0-6a2,2,0,1,1-2,2A2,2,0,0,1,12,6ZM16,22.03l8,1.948V13.483a3,3,0,0,0-2.133-2.871l-2.1-.7A8.037,8.037,0,0,0,20,8.006a8,8,0,0,0-16,0,8.111,8.111,0,0,0,.1,1.212A2.992,2.992,0,0,0,0,12v9.752l7.983,2.281ZM7.757,3.764a6,6,0,0,1,8.493,8.477L12,16.4,7.757,12.249a6,6,0,0,1,0-8.485ZM2,12a.985.985,0,0,1,.446-.832A1.007,1.007,0,0,1,3.43,11.1l1.434.518a8.036,8.036,0,0,0,1.487,2.056L12,19.2l5.657-5.533a8.032,8.032,0,0,0,1.4-1.882l2.217.741a1,1,0,0,1,.725.961v7.949L16,19.97l-7.98,2L2,20.246Z"/></svg>
                    <p>ศูนย์เรียนรวม 3</p>
                    <svg id="Layer_1" class="w-4 h-4 ml-2" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><path d="m23 14h-1v-9a5.006 5.006 0 0 0 -5-5h-10a5.006 5.006 0 0 0 -5 5v9h-1a1 1 0 0 0 0 2h10v4h-2a3 3 0 0 0 -3 3 1 1 0 0 0 2 0 1 1 0 0 1 1-1h6a1 1 0 0 1 1 1 1 1 0 0 0 2 0 3 3 0 0 0 -3-3h-2v-4h10a1 1 0 0 0 0-2zm-19-9a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v9h-16z"/></svg>
                    <p>213, 214</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md px-3 py-3 font-light">
                <div class="px-2 pt-1 fill-gray-500 text-gray-500 flex items-center gap-1.5"> 
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><path d="M13,2.051V1a1,1,0,0,0-2,0V2.051A10.98,10.98,0,0,0,3.681,20.176,3.024,3.024,0,0,0,2,23a1,1,0,0,0,2,0,1.2,1.2,0,0,1,1.11-1.229.932.932,0,0,0,.2-.062,10.924,10.924,0,0,0,13.39,0,1.033,1.033,0,0,0,.182.064A1.2,1.2,0,0,1,20,23a1,1,0,0,0,2,0,3.024,3.024,0,0,0-1.681-2.824A10.98,10.98,0,0,0,13,2.051ZM3,13a9,9,0,1,1,9,9A9.011,9.011,0,0,1,3,13Z"/><path d="M19.215,0a1,1,0,0,0,0,2A2.59,2.59,0,0,1,22,4.5a1,1,0,0,0,2,0A4.6,4.6,0,0,0,19.215,0Z"/><path d="M2,4.5A2.59,2.59,0,0,1,4.785,2a1,1,0,0,0,0-2A4.6,4.6,0,0,0,0,4.5a1,1,0,0,0,2,0Z"/><path d="M13,11.586V7a1,1,0,0,0-2,0v5a1,1,0,0,0,.293.707l3,3a1,1,0,0,0,1.414-1.414Z"/></svg>
                    <p>9.00</p>
                    <p>-</p>
                    <p>12.00</p>
                    <p class="w-max ml-2 py-1 px-2 -translate-y-0.5 bg-gradient-to-tr from-green-600 to-green-400 rounded-lg text-sm text-white shadow-md">
                พร้อมจัดสอบ
            </p>
                </div>
                <div class="px-2 pt-1 font-semibold text-2xl">
                    <p>เจ้าหน้าที่บริหารงานทั่วไประดับปฏิบัติการ</p>
                </div>
                <div class="px-2 pt-1 flex items-center gap-1.5">
                    <p id="department_name">งานบริหารระบบเอกสารกลาง,</p>
                    <p id="organization">สำนักกองบริหารกลาง</p>
                </div>
                <div class="px-2 pt-1 pb-1 fill-gray-500 text-gray-500 flex items-center gap-1.5"> 
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><path d="M12,12A4,4,0,1,0,8,8,4,4,0,0,0,12,12Zm0-6a2,2,0,1,1-2,2A2,2,0,0,1,12,6ZM16,22.03l8,1.948V13.483a3,3,0,0,0-2.133-2.871l-2.1-.7A8.037,8.037,0,0,0,20,8.006a8,8,0,0,0-16,0,8.111,8.111,0,0,0,.1,1.212A2.992,2.992,0,0,0,0,12v9.752l7.983,2.281ZM7.757,3.764a6,6,0,0,1,8.493,8.477L12,16.4,7.757,12.249a6,6,0,0,1,0-8.485ZM2,12a.985.985,0,0,1,.446-.832A1.007,1.007,0,0,1,3.43,11.1l1.434.518a8.036,8.036,0,0,0,1.487,2.056L12,19.2l5.657-5.533a8.032,8.032,0,0,0,1.4-1.882l2.217.741a1,1,0,0,1,.725.961v7.949L16,19.97l-7.98,2L2,20.246Z"/></svg>
                    <p>ศูนย์เรียนรวม 3</p>
                    <svg id="Layer_1" class="w-4 h-4 ml-2" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><path d="m23 14h-1v-9a5.006 5.006 0 0 0 -5-5h-10a5.006 5.006 0 0 0 -5 5v9h-1a1 1 0 0 0 0 2h10v4h-2a3 3 0 0 0 -3 3 1 1 0 0 0 2 0 1 1 0 0 1 1-1h6a1 1 0 0 1 1 1 1 1 0 0 0 2 0 3 3 0 0 0 -3-3h-2v-4h10a1 1 0 0 0 0-2zm-19-9a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v9h-16z"/></svg>
                    <p>213, 214</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md px-3 py-3 font-light">
                <div class="px-2 pt-1 fill-gray-500 text-gray-500 flex items-center gap-1.5"> 
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><path d="M13,2.051V1a1,1,0,0,0-2,0V2.051A10.98,10.98,0,0,0,3.681,20.176,3.024,3.024,0,0,0,2,23a1,1,0,0,0,2,0,1.2,1.2,0,0,1,1.11-1.229.932.932,0,0,0,.2-.062,10.924,10.924,0,0,0,13.39,0,1.033,1.033,0,0,0,.182.064A1.2,1.2,0,0,1,20,23a1,1,0,0,0,2,0,3.024,3.024,0,0,0-1.681-2.824A10.98,10.98,0,0,0,13,2.051ZM3,13a9,9,0,1,1,9,9A9.011,9.011,0,0,1,3,13Z"/><path d="M19.215,0a1,1,0,0,0,0,2A2.59,2.59,0,0,1,22,4.5a1,1,0,0,0,2,0A4.6,4.6,0,0,0,19.215,0Z"/><path d="M2,4.5A2.59,2.59,0,0,1,4.785,2a1,1,0,0,0,0-2A4.6,4.6,0,0,0,0,4.5a1,1,0,0,0,2,0Z"/><path d="M13,11.586V7a1,1,0,0,0-2,0v5a1,1,0,0,0,.293.707l3,3a1,1,0,0,0,1.414-1.414Z"/></svg>
                    <p>9.00</p>
                    <p>-</p>
                    <p>12.00</p>
                    <p class="w-max ml-2 py-1 px-2 -translate-y-0.5 bg-gradient-to-tr from-green-600 to-green-400 rounded-lg text-sm text-white shadow-md">
                พร้อมจัดสอบ
            </p>
                </div>
                <div class="px-2 pt-1 font-semibold text-2xl">
                    <p>เจ้าหน้าที่บริหารงานทั่วไประดับปฏิบัติการ</p>
                </div>
                <div class="px-2 pt-1 flex items-center gap-1.5">
                    <p id="department_name">งานบริหารระบบเอกสารกลาง,</p>
                    <p id="organization">สำนักกองบริหารกลาง</p>
                </div>
                <div class="px-2 pt-1 pb-1 fill-gray-500 text-gray-500 flex items-center gap-1.5"> 
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><path d="M12,12A4,4,0,1,0,8,8,4,4,0,0,0,12,12Zm0-6a2,2,0,1,1-2,2A2,2,0,0,1,12,6ZM16,22.03l8,1.948V13.483a3,3,0,0,0-2.133-2.871l-2.1-.7A8.037,8.037,0,0,0,20,8.006a8,8,0,0,0-16,0,8.111,8.111,0,0,0,.1,1.212A2.992,2.992,0,0,0,0,12v9.752l7.983,2.281ZM7.757,3.764a6,6,0,0,1,8.493,8.477L12,16.4,7.757,12.249a6,6,0,0,1,0-8.485ZM2,12a.985.985,0,0,1,.446-.832A1.007,1.007,0,0,1,3.43,11.1l1.434.518a8.036,8.036,0,0,0,1.487,2.056L12,19.2l5.657-5.533a8.032,8.032,0,0,0,1.4-1.882l2.217.741a1,1,0,0,1,.725.961v7.949L16,19.97l-7.98,2L2,20.246Z"/></svg>
                    <p>ศูนย์เรียนรวม 3</p>
                    <svg id="Layer_1" class="w-4 h-4 ml-2" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><path d="m23 14h-1v-9a5.006 5.006 0 0 0 -5-5h-10a5.006 5.006 0 0 0 -5 5v9h-1a1 1 0 0 0 0 2h10v4h-2a3 3 0 0 0 -3 3 1 1 0 0 0 2 0 1 1 0 0 1 1-1h6a1 1 0 0 1 1 1 1 1 0 0 0 2 0 3 3 0 0 0 -3-3h-2v-4h10a1 1 0 0 0 0-2zm-19-9a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v9h-16z"/></svg>
                    <p>213, 214</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md px-3 py-3 font-light">
                <div class="px-2 pt-1 fill-gray-500 text-gray-500 flex items-center gap-1.5"> 
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><path d="M13,2.051V1a1,1,0,0,0-2,0V2.051A10.98,10.98,0,0,0,3.681,20.176,3.024,3.024,0,0,0,2,23a1,1,0,0,0,2,0,1.2,1.2,0,0,1,1.11-1.229.932.932,0,0,0,.2-.062,10.924,10.924,0,0,0,13.39,0,1.033,1.033,0,0,0,.182.064A1.2,1.2,0,0,1,20,23a1,1,0,0,0,2,0,3.024,3.024,0,0,0-1.681-2.824A10.98,10.98,0,0,0,13,2.051ZM3,13a9,9,0,1,1,9,9A9.011,9.011,0,0,1,3,13Z"/><path d="M19.215,0a1,1,0,0,0,0,2A2.59,2.59,0,0,1,22,4.5a1,1,0,0,0,2,0A4.6,4.6,0,0,0,19.215,0Z"/><path d="M2,4.5A2.59,2.59,0,0,1,4.785,2a1,1,0,0,0,0-2A4.6,4.6,0,0,0,0,4.5a1,1,0,0,0,2,0Z"/><path d="M13,11.586V7a1,1,0,0,0-2,0v5a1,1,0,0,0,.293.707l3,3a1,1,0,0,0,1.414-1.414Z"/></svg>
                    <p>9.00</p>
                    <p>-</p>
                    <p>12.00</p>
                    <p class="w-max ml-2 py-1 px-2 -translate-y-0.5 bg-gradient-to-tr from-green-600 to-green-400 rounded-lg text-sm text-white shadow-md">
                พร้อมจัดสอบ
            </p>
                </div>
                <div class="px-2 pt-1 font-semibold text-2xl">
                    <p>เจ้าหน้าที่บริหารงานทั่วไประดับปฏิบัติการ</p>
                </div>
                <div class="px-2 pt-1 flex items-center gap-1.5">
                    <p id="department_name">งานบริหารระบบเอกสารกลาง,</p>
                    <p id="organization">สำนักกองบริหารกลาง</p>
                </div>
                <div class="px-2 pt-1 pb-1 fill-gray-500 text-gray-500 flex items-center gap-1.5"> 
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><path d="M12,12A4,4,0,1,0,8,8,4,4,0,0,0,12,12Zm0-6a2,2,0,1,1-2,2A2,2,0,0,1,12,6ZM16,22.03l8,1.948V13.483a3,3,0,0,0-2.133-2.871l-2.1-.7A8.037,8.037,0,0,0,20,8.006a8,8,0,0,0-16,0,8.111,8.111,0,0,0,.1,1.212A2.992,2.992,0,0,0,0,12v9.752l7.983,2.281ZM7.757,3.764a6,6,0,0,1,8.493,8.477L12,16.4,7.757,12.249a6,6,0,0,1,0-8.485ZM2,12a.985.985,0,0,1,.446-.832A1.007,1.007,0,0,1,3.43,11.1l1.434.518a8.036,8.036,0,0,0,1.487,2.056L12,19.2l5.657-5.533a8.032,8.032,0,0,0,1.4-1.882l2.217.741a1,1,0,0,1,.725.961v7.949L16,19.97l-7.98,2L2,20.246Z"/></svg>
                    <p>ศูนย์เรียนรวม 3</p>
                    <svg id="Layer_1" class="w-4 h-4 ml-2" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><path d="m23 14h-1v-9a5.006 5.006 0 0 0 -5-5h-10a5.006 5.006 0 0 0 -5 5v9h-1a1 1 0 0 0 0 2h10v4h-2a3 3 0 0 0 -3 3 1 1 0 0 0 2 0 1 1 0 0 1 1-1h6a1 1 0 0 1 1 1 1 1 0 0 0 2 0 3 3 0 0 0 -3-3h-2v-4h10a1 1 0 0 0 0-2zm-19-9a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v9h-16z"/></svg>
                    <p>213, 214</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md px-3 py-3 font-light">
                <div class="px-2 pt-1 fill-gray-500 text-gray-500 flex items-center gap-1.5"> 
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><path d="M13,2.051V1a1,1,0,0,0-2,0V2.051A10.98,10.98,0,0,0,3.681,20.176,3.024,3.024,0,0,0,2,23a1,1,0,0,0,2,0,1.2,1.2,0,0,1,1.11-1.229.932.932,0,0,0,.2-.062,10.924,10.924,0,0,0,13.39,0,1.033,1.033,0,0,0,.182.064A1.2,1.2,0,0,1,20,23a1,1,0,0,0,2,0,3.024,3.024,0,0,0-1.681-2.824A10.98,10.98,0,0,0,13,2.051ZM3,13a9,9,0,1,1,9,9A9.011,9.011,0,0,1,3,13Z"/><path d="M19.215,0a1,1,0,0,0,0,2A2.59,2.59,0,0,1,22,4.5a1,1,0,0,0,2,0A4.6,4.6,0,0,0,19.215,0Z"/><path d="M2,4.5A2.59,2.59,0,0,1,4.785,2a1,1,0,0,0,0-2A4.6,4.6,0,0,0,0,4.5a1,1,0,0,0,2,0Z"/><path d="M13,11.586V7a1,1,0,0,0-2,0v5a1,1,0,0,0,.293.707l3,3a1,1,0,0,0,1.414-1.414Z"/></svg>
                    <p>9.00</p>
                    <p>-</p>
                    <p>12.00</p>
                    <p class="w-max ml-2 py-1 px-2 -translate-y-0.5 bg-gradient-to-tr from-green-600 to-green-400 rounded-lg text-sm text-white shadow-md">
                พร้อมจัดสอบ
            </p>
                </div>
                <div class="px-2 pt-1 font-semibold text-2xl">
                    <p>เจ้าหน้าที่บริหารงานทั่วไประดับปฏิบัติการ</p>
                </div>
                <div class="px-2 pt-1 flex items-center gap-1.5">
                    <p id="department_name">งานบริหารระบบเอกสารกลาง,</p>
                    <p id="organization">สำนักกองบริหารกลาง</p>
                </div>
                <div class="px-2 pt-1 pb-1 fill-gray-500 text-gray-500 flex items-center gap-1.5"> 
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><path d="M12,12A4,4,0,1,0,8,8,4,4,0,0,0,12,12Zm0-6a2,2,0,1,1-2,2A2,2,0,0,1,12,6ZM16,22.03l8,1.948V13.483a3,3,0,0,0-2.133-2.871l-2.1-.7A8.037,8.037,0,0,0,20,8.006a8,8,0,0,0-16,0,8.111,8.111,0,0,0,.1,1.212A2.992,2.992,0,0,0,0,12v9.752l7.983,2.281ZM7.757,3.764a6,6,0,0,1,8.493,8.477L12,16.4,7.757,12.249a6,6,0,0,1,0-8.485ZM2,12a.985.985,0,0,1,.446-.832A1.007,1.007,0,0,1,3.43,11.1l1.434.518a8.036,8.036,0,0,0,1.487,2.056L12,19.2l5.657-5.533a8.032,8.032,0,0,0,1.4-1.882l2.217.741a1,1,0,0,1,.725.961v7.949L16,19.97l-7.98,2L2,20.246Z"/></svg>
                    <p>ศูนย์เรียนรวม 3</p>
                    <svg id="Layer_1" class="w-4 h-4 ml-2" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><path d="m23 14h-1v-9a5.006 5.006 0 0 0 -5-5h-10a5.006 5.006 0 0 0 -5 5v9h-1a1 1 0 0 0 0 2h10v4h-2a3 3 0 0 0 -3 3 1 1 0 0 0 2 0 1 1 0 0 1 1-1h6a1 1 0 0 1 1 1 1 1 0 0 0 2 0 3 3 0 0 0 -3-3h-2v-4h10a1 1 0 0 0 0-2zm-19-9a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v9h-16z"/></svg>
                    <p>213, 214</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md px-3 py-3 font-light">
                <div class="px-2 pt-1 fill-gray-500 text-gray-500 flex items-center gap-1.5"> 
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><path d="M13,2.051V1a1,1,0,0,0-2,0V2.051A10.98,10.98,0,0,0,3.681,20.176,3.024,3.024,0,0,0,2,23a1,1,0,0,0,2,0,1.2,1.2,0,0,1,1.11-1.229.932.932,0,0,0,.2-.062,10.924,10.924,0,0,0,13.39,0,1.033,1.033,0,0,0,.182.064A1.2,1.2,0,0,1,20,23a1,1,0,0,0,2,0,3.024,3.024,0,0,0-1.681-2.824A10.98,10.98,0,0,0,13,2.051ZM3,13a9,9,0,1,1,9,9A9.011,9.011,0,0,1,3,13Z"/><path d="M19.215,0a1,1,0,0,0,0,2A2.59,2.59,0,0,1,22,4.5a1,1,0,0,0,2,0A4.6,4.6,0,0,0,19.215,0Z"/><path d="M2,4.5A2.59,2.59,0,0,1,4.785,2a1,1,0,0,0,0-2A4.6,4.6,0,0,0,0,4.5a1,1,0,0,0,2,0Z"/><path d="M13,11.586V7a1,1,0,0,0-2,0v5a1,1,0,0,0,.293.707l3,3a1,1,0,0,0,1.414-1.414Z"/></svg>
                    <p>9.00</p>
                    <p>-</p>
                    <p>12.00</p>
                    <p class="w-max ml-2 py-1 px-2 -translate-y-0.5 bg-gradient-to-tr from-green-600 to-green-400 rounded-lg text-sm text-white shadow-md">
                พร้อมจัดสอบ
            </p>
                </div>
                <div class="px-2 pt-1 font-semibold text-2xl">
                    <p>เจ้าหน้าที่บริหารงานทั่วไประดับปฏิบัติการ</p>
                </div>
                <div class="px-2 pt-1 flex items-center gap-1.5">
                    <p id="department_name">งานบริหารระบบเอกสารกลาง,</p>
                    <p id="organization">สำนักกองบริหารกลาง</p>
                </div>
                <div class="px-2 pt-1 pb-1 fill-gray-500 text-gray-500 flex items-center gap-1.5"> 
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><path d="M12,12A4,4,0,1,0,8,8,4,4,0,0,0,12,12Zm0-6a2,2,0,1,1-2,2A2,2,0,0,1,12,6ZM16,22.03l8,1.948V13.483a3,3,0,0,0-2.133-2.871l-2.1-.7A8.037,8.037,0,0,0,20,8.006a8,8,0,0,0-16,0,8.111,8.111,0,0,0,.1,1.212A2.992,2.992,0,0,0,0,12v9.752l7.983,2.281ZM7.757,3.764a6,6,0,0,1,8.493,8.477L12,16.4,7.757,12.249a6,6,0,0,1,0-8.485ZM2,12a.985.985,0,0,1,.446-.832A1.007,1.007,0,0,1,3.43,11.1l1.434.518a8.036,8.036,0,0,0,1.487,2.056L12,19.2l5.657-5.533a8.032,8.032,0,0,0,1.4-1.882l2.217.741a1,1,0,0,1,.725.961v7.949L16,19.97l-7.98,2L2,20.246Z"/></svg>
                    <p>ศูนย์เรียนรวม 3</p>
                    <svg id="Layer_1" class="w-4 h-4 ml-2" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><path d="m23 14h-1v-9a5.006 5.006 0 0 0 -5-5h-10a5.006 5.006 0 0 0 -5 5v9h-1a1 1 0 0 0 0 2h10v4h-2a3 3 0 0 0 -3 3 1 1 0 0 0 2 0 1 1 0 0 1 1-1h6a1 1 0 0 1 1 1 1 1 0 0 0 2 0 3 3 0 0 0 -3-3h-2v-4h10a1 1 0 0 0 0-2zm-19-9a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v9h-16z"/></svg>
                    <p>213, 214</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md px-3 py-3 font-light">
                <div class="px-2 pt-1 fill-gray-500 text-gray-500 flex items-center gap-1.5"> 
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><path d="M13,2.051V1a1,1,0,0,0-2,0V2.051A10.98,10.98,0,0,0,3.681,20.176,3.024,3.024,0,0,0,2,23a1,1,0,0,0,2,0,1.2,1.2,0,0,1,1.11-1.229.932.932,0,0,0,.2-.062,10.924,10.924,0,0,0,13.39,0,1.033,1.033,0,0,0,.182.064A1.2,1.2,0,0,1,20,23a1,1,0,0,0,2,0,3.024,3.024,0,0,0-1.681-2.824A10.98,10.98,0,0,0,13,2.051ZM3,13a9,9,0,1,1,9,9A9.011,9.011,0,0,1,3,13Z"/><path d="M19.215,0a1,1,0,0,0,0,2A2.59,2.59,0,0,1,22,4.5a1,1,0,0,0,2,0A4.6,4.6,0,0,0,19.215,0Z"/><path d="M2,4.5A2.59,2.59,0,0,1,4.785,2a1,1,0,0,0,0-2A4.6,4.6,0,0,0,0,4.5a1,1,0,0,0,2,0Z"/><path d="M13,11.586V7a1,1,0,0,0-2,0v5a1,1,0,0,0,.293.707l3,3a1,1,0,0,0,1.414-1.414Z"/></svg>
                    <p>9.00</p>
                    <p>-</p>
                    <p>12.00</p>
                    <p class="w-max ml-2 py-1 px-2 -translate-y-0.5 bg-gradient-to-tr from-green-600 to-green-400 rounded-lg text-sm text-white shadow-md">
                พร้อมจัดสอบ
            </p>
                </div>
                <div class="px-2 pt-1 font-semibold text-2xl">
                    <p>เจ้าหน้าที่บริหารงานทั่วไประดับปฏิบัติการ</p>
                </div>
                <div class="px-2 pt-1 flex items-center gap-1.5">
                    <p id="department_name">งานบริหารระบบเอกสารกลาง,</p>
                    <p id="organization">สำนักกองบริหารกลาง</p>
                </div>
                <div class="px-2 pt-1 pb-1 fill-gray-500 text-gray-500 flex items-center gap-1.5"> 
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><path d="M12,12A4,4,0,1,0,8,8,4,4,0,0,0,12,12Zm0-6a2,2,0,1,1-2,2A2,2,0,0,1,12,6ZM16,22.03l8,1.948V13.483a3,3,0,0,0-2.133-2.871l-2.1-.7A8.037,8.037,0,0,0,20,8.006a8,8,0,0,0-16,0,8.111,8.111,0,0,0,.1,1.212A2.992,2.992,0,0,0,0,12v9.752l7.983,2.281ZM7.757,3.764a6,6,0,0,1,8.493,8.477L12,16.4,7.757,12.249a6,6,0,0,1,0-8.485ZM2,12a.985.985,0,0,1,.446-.832A1.007,1.007,0,0,1,3.43,11.1l1.434.518a8.036,8.036,0,0,0,1.487,2.056L12,19.2l5.657-5.533a8.032,8.032,0,0,0,1.4-1.882l2.217.741a1,1,0,0,1,.725.961v7.949L16,19.97l-7.98,2L2,20.246Z"/></svg>
                    <p>ศูนย์เรียนรวม 3</p>
                    <svg id="Layer_1" class="w-4 h-4 ml-2" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><path d="m23 14h-1v-9a5.006 5.006 0 0 0 -5-5h-10a5.006 5.006 0 0 0 -5 5v9h-1a1 1 0 0 0 0 2h10v4h-2a3 3 0 0 0 -3 3 1 1 0 0 0 2 0 1 1 0 0 1 1-1h6a1 1 0 0 1 1 1 1 1 0 0 0 2 0 3 3 0 0 0 -3-3h-2v-4h10a1 1 0 0 0 0-2zm-19-9a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v9h-16z"/></svg>
                    <p>213, 214</p>
                </div>
            </div>
            
        </div>
    </div>
</div>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        
        var calendar = new FullCalendar.Calendar(calendarEl, {
            events: function(fetchInfo, successCallback, failureCallback) {
                $.ajax({
                    url: '/calendar/exams',
                    type: 'GET',
                    success: function(data) {
                        // รวบรวมข้อมูลตาม status
                        var statusCount = {};
                        data.forEach(function(exam) {
                            var date = exam.exam_date.split(' ')[0];
                            if (!statusCount[date]) {
                                statusCount[date] = {};
                            }
                            if (!statusCount[date][exam.status]) {
                                statusCount[date][exam.status] = 0;
                            }
                            statusCount[date][exam.status]++;
                        });

                        // แปลงข้อมูลให้เป็นรูปแบบที่ FullCalendar ต้องการ
                        var events = [];
                        for (var date in statusCount) {
                            for (var status in statusCount[date]) {
                                events.push({
                                    title: `${statusCount[date][status]}`,
                                    start: date,
                                    allDay: true,
                                    status: status,
                                });
                            }
                        }
                        successCallback(events);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error fetching events:', textStatus, errorThrown);
                        failureCallback();
                    }
                });
            },
            initialView: 'dayGridMonth',
            editable: false,
            selectable: true,
            dayCellContent: function(arg) {
                // กำหนดเนื้อหาของแต่ละช่องวัน
                var cellContent = document.createElement('div');
                cellContent.textContent = arg.date.getDate(); // แสดงวันที่

                // ใช้ Tailwind CSS ในการปรับแต่ง
                cellContent.classList.add('text-lg', 'text-center');

                return { domNodes: [cellContent] };
            },
            eventContent: function(arg) {
                // Custom rendering for event
                let event = arg.event;
                let content = document.createElement('div');
                content.classList.add('custom-event', 'items-center', 'rounded-full', 'px-2', 'py-0.5', 'w-max', 'text-center', 'bg-gradient-to-tr',);
                // เช็ค status เพื่อปรับแต่งการแสดงผล
                if (event.extendedProps.status === 'unready') {
                    content.classList.add('from-red-400', 'to-red-600');
                } else if (event.extendedProps.status === 'pending') {
                    content.classList.add('from-yellow-400', 'to-yellow-600');
                } else if (event.extendedProps.status === 'ready') {
                    content.classList.add('from-green-400', 'to-green-600');
                } else if (event.extendedProps.status === 'inprogress') {
                    content.classList.add('from-cyan-400', 'to-cyan-600');
                } else if (event.extendedProps.status === 'finished') {
                    content.classList.add('from-gray-400', 'to-gray-600');
                } else if (event.extendedProps.status === 'unfinished') {
                    content.classList.add('from-orange-400', 'to-orange-600');
                }
                content.innerHTML = `
                    ${event.title}

                `;
                return { domNodes: [content] };
            },
            dateClick: function(info) {
                // Clear previous selections
                document.querySelectorAll('.fc-daygrid-day').forEach(function(el) {
                el.classList.remove('selected-date');
                });
                
                // Add selected-date class to the clicked date
                var dateStr = info.dateStr;
                document.querySelectorAll('[data-date="' + dateStr + '"]').forEach(function(el) {
                el.classList.add('selected-date');
                });
            }
        });

        calendar.render();

        document.getElementById('rerenderBtn').addEventListener('click', function() {
            setTimeout(function() {
                calendar.render();
            }, 500); 
        });
    });


</script>

<style>
    .fc-event, .fc-event-dot {
        background-color: transparent !important; /* ลบสีพื้นหลัง */
        border-color: transparent !important; /* ลบเส้นขอบ */
    }
    .fc-daygrid-day-events {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        align-items: center;
        padding-left: 4px;
        padding-right: 4px;
    }
</style>

@endsection