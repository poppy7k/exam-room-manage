<!-- resources/views/components/alert.blade.php -->
@if(session('notify'))
    <div class="absolute flex w-screen justify-center">
        <div
            x-cloak
            x-data="{ show: true }"
            x-show="show"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-90 translate-x-60 scale-75"
            x-init="() => { setTimeout(() => show = true, 100); setTimeout(() => show = false, 2100); }"
            class="flex items-center justify-between fixed rounded-lg bottom-6 right-6 transform w-max z-50 px-5 py-3 text-black bg-white shadow-lg
                @if(session('notify.type') === 'success') text-black fill-green-500 border-2 border-green-500 @endif
                @if(session('notify.type') === 'danger') text-black fill-red-500 border-2 border-red-500 @endif
                @if(session('notify.type') === 'info') bg-blue-400 @endif
                @if(session('notify.type') === 'warning') bg-yellow-400 @endif
            "
        >
            <div class="flex items-start">
                @if(session('notify.type') === 'success') 
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 fill-green-600" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="24" height="24"><path d="m12,0C5.383,0,0,5.383,0,12s5.383,12,12,12,12-5.383,12-12S18.617,0,12,0Zm-.091,15.419c-.387.387-.896.58-1.407.58s-1.025-.195-1.416-.585l-2.782-2.696,1.393-1.437,2.793,2.707,5.809-5.701,1.404,1.425-5.793,5.707Z"/></svg>
                @elseif(session('notify.type') === 'danger') 
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-red-600 -mt-0.5" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512"><path d="M23.64,18.1L14.24,2.28c-.47-.8-1.3-1.28-2.24-1.28s-1.77,.48-2.23,1.28L.36,18.1h0c-.47,.82-.47,1.79,0,2.6s1.31,1.3,2.24,1.3H21.41c.94,0,1.78-.49,2.24-1.3s.46-1.78-.01-2.6Zm-10.64-.1h-2v-2h2v2Zm0-4h-2v-6h2v6Z"/></svg>
                @elseif(session('notify.type') === 'info') 
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-blue-600" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="24" height="24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14h-2v-6h2v6zm1-8h-2V7h2v1z"/></svg>
                @elseif(session('notify.type') === 'warning') 
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-yellow-600" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="24" height="24"><path d="M1 21h22L12 2 1 21zM12 16v2h-2v-2h2zm0-6v4h-2V10h2z"/></svg>
                @endif
                <div class="ml-4">
                    <h3 class="font-bold">{{ session('notify.title') }}</h3>
                    <p>{{ session('notify.message') }}</p>
                </div>
            </div>
            <button @click="show = false" class="ml-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>
    </div>
@endif

<script>
    function showNotification(type, title, message) {
        fetch('/notifications', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ type, title, message })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                //console.log('Notification sent successfully.');
                location.reload()
            } else {
                //console.log('Failed to send notification.');
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>