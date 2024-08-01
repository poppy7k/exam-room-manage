<div x-show="showApplicantAdd" @click.outside="showApplicantAdd = false"  id="ApplicantAdd" class="absolute -translate-x-24 z-40"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 -translate-y-16 scale-90"
    x-transition:enter-end="opacity-100 -translate-y-0 scale-100"
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100 scale-100 -translate-y-0"
    x-transition:leave-end="opacity-0 scale-90 -translate-y-16">
    <div class="relative flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="align-bottom bg-white border-2 border-gray-800/20 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-4 pt-2 pb-4">
                <p class="my-2 font-semibold text-xl">
                </p>
                <div id="applicantAdd" class="flex gap-4">
                    <div class="w-full flex-col content-center justify-center">
                        <x-buttons.primary id="applicant-add-left-to-right" onclick="assignAllApplicantsToSeats('left-to-right')" type="button" class="pl-2 py-2 z-10 w-10 h-10 rounded-lg fill-white">
                            <div class="absolute -mt-1 ml-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="20" height="20"><path d="M23.12,9.91,19.25,6a1,1,0,0,0-1.42,0h0a1,1,0,0,0,0,1.41L21.39,11H1a1,1,0,0,0-1,1H0a1,1,0,0,0,1,1H21.45l-3.62,3.61a1,1,0,0,0,0,1.42h0a1,1,0,0,0,1.42,0l3.87-3.88A3,3,0,0,0,23.12,9.91Z"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="-mt-1.5" id="Outline" viewBox="0 0 24 24" width="20" height="20"><path d="M23.12,9.91,19.25,6a1,1,0,0,0-1.42,0h0a1,1,0,0,0,0,1.41L21.39,11H1a1,1,0,0,0-1,1H0a1,1,0,0,0,1,1H21.45l-3.62,3.61a1,1,0,0,0,0,1.42h0a1,1,0,0,0,1.42,0l3.87-3.88A3,3,0,0,0,23.12,9.91Z"/></svg>
                            </div>
                        </x-buttons.primary>
                    </div>
                    <div>
                        <x-buttons.primary id="applicant-add-alternate-left-right" onclick="assignAllApplicantsToSeats('alternate-left-right')" type="button" class="pl-2 py-2 z-10 w-10 h-10 rounded-lg fill-white">
                            <div class="absolute -mt-1 ml-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="20" height="20"><path d="M23.12,9.91,19.25,6a1,1,0,0,0-1.42,0h0a1,1,0,0,0,0,1.41L21.39,11H1a1,1,0,0,0-1,1H0a1,1,0,0,0,1,1H21.45l-3.62,3.61a1,1,0,0,0,0,1.42h0a1,1,0,0,0,1.42,0l3.87-3.88A3,3,0,0,0,23.12,9.91Z"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="-mt-1.5 rotate-180" id="Outline" viewBox="0 0 24 24" width="20" height="20"><path d="M23.12,9.91,19.25,6a1,1,0,0,0-1.42,0h0a1,1,0,0,0,0,1.41L21.39,11H1a1,1,0,0,0-1,1H0a1,1,0,0,0,1,1H21.45l-3.62,3.61a1,1,0,0,0,0,1.42h0a1,1,0,0,0,1.42,0l3.87-3.88A3,3,0,0,0,23.12,9.91Z"/></svg>
                            </div>
                        </x-buttons.primary>
                    </div>
                    <div>
                        <x-buttons.primary id="applicant-add-right-to-left" onclick="assignAllApplicantsToSeats('right-to-left')" type="button" class="pl-2 py-2 z-10 w-10 h-10 rounded-lg fill-white">
                            <div class="absolute -mt-1 ml-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="rotate-180" id="Outline" viewBox="0 0 24 24" width="20" height="20"><path d="M23.12,9.91,19.25,6a1,1,0,0,0-1.42,0h0a1,1,0,0,0,0,1.41L21.39,11H1a1,1,0,0,0-1,1H0a1,1,0,0,0,1,1H21.45l-3.62,3.61a1,1,0,0,0,0,1.42h0a1,1,0,0,0,1.42,0l3.87-3.88A3,3,0,0,0,23.12,9.91Z"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="-mt-1.5 rotate-180" id="Outline" viewBox="0 0 24 24" width="20" height="20"><path d="M23.12,9.91,19.25,6a1,1,0,0,0-1.42,0h0a1,1,0,0,0,0,1.41L21.39,11H1a1,1,0,0,0-1,1H0a1,1,0,0,0,1,1H21.45l-3.62,3.61a1,1,0,0,0,0,1.42h0a1,1,0,0,0,1.42,0l3.87-3.88A3,3,0,0,0,23.12,9.91Z"/></svg>
                            </div>
                        </x-buttons.primary>
                    </div>
                    <div>
                        <x-buttons.primary id="applicant-add-alternate-right-left" onclick="assignAllApplicantsToSeats('alternate-right-left')" type="button" class="pl-2 py-2 z-10 w-10 h-10 rounded-lg fill-white">
                            <div class="absolute -mt-1 ml-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="rotate-180" id="Outline" viewBox="0 0 24 24" width="20" height="20"><path d="M23.12,9.91,19.25,6a1,1,0,0,0-1.42,0h0a1,1,0,0,0,0,1.41L21.39,11H1a1,1,0,0,0-1,1H0a1,1,0,0,0,1,1H21.45l-3.62,3.61a1,1,0,0,0,0,1.42h0a1,1,0,0,0,1.42,0l3.87-3.88A3,3,0,0,0,23.12,9.91Z"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="-mt-1.5" id="Outline" viewBox="0 0 24 24" width="20" height="20"><path d="M23.12,9.91,19.25,6a1,1,0,0,0-1.42,0h0a1,1,0,0,0,0,1.41L21.39,11H1a1,1,0,0,0-1,1H0a1,1,0,0,0,1,1H21.45l-3.62,3.61a1,1,0,0,0,0,1.42h0a1,1,0,0,0,1.42,0l3.87-3.88A3,3,0,0,0,23.12,9.91Z"/></svg>
                            </div>
                        </x-buttons.primary>
                    </div>
                </div>
                <div id="applicantAdd" class="flex mt-4 gap-4">
                    <div>
                        <x-buttons.primary id="applicant-add-top-to-bottom" onclick="assignAllApplicantsToSeats('top-to-bottom')" type="button" class="pl-2 py-2 z-10 w-10 h-10 rounded-lg fill-white">
                            <div class="absolute -ml-1 mt-0.5 flex">
                                <svg xmlns="http://www.w3.org/2000/svg" class="rotate-90" id="Outline" viewBox="0 0 24 24" width="20" height="20"><path d="M23.12,9.91,19.25,6a1,1,0,0,0-1.42,0h0a1,1,0,0,0,0,1.41L21.39,11H1a1,1,0,0,0-1,1H0a1,1,0,0,0,1,1H21.45l-3.62,3.61a1,1,0,0,0,0,1.42h0a1,1,0,0,0,1.42,0l3.87-3.88A3,3,0,0,0,23.12,9.91Z"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1.5 rotate-90" id="Outline" viewBox="0 0 24 24" width="20" height="20"><path d="M23.12,9.91,19.25,6a1,1,0,0,0-1.42,0h0a1,1,0,0,0,0,1.41L21.39,11H1a1,1,0,0,0-1,1H0a1,1,0,0,0,1,1H21.45l-3.62,3.61a1,1,0,0,0,0,1.42h0a1,1,0,0,0,1.42,0l3.87-3.88A3,3,0,0,0,23.12,9.91Z"/></svg>
                            </div>
                        </x-buttons.primary>
                    </div>
                    <div>
                        <x-buttons.primary id="applicant-add-alternate-top-bottom" onclick="assignAllApplicantsToSeats('alternate-top-bottom')" type="button" class="pl-2 py-2 z-10 w-10 h-10 rounded-lg fill-white">
                            <div class="absolute -ml-1 mt-0.5 flex">
                                <svg xmlns="http://www.w3.org/2000/svg" class="rotate-90" id="Outline" viewBox="0 0 24 24" width="20" height="20"><path d="M23.12,9.91,19.25,6a1,1,0,0,0-1.42,0h0a1,1,0,0,0,0,1.41L21.39,11H1a1,1,0,0,0-1,1H0a1,1,0,0,0,1,1H21.45l-3.62,3.61a1,1,0,0,0,0,1.42h0a1,1,0,0,0,1.42,0l3.87-3.88A3,3,0,0,0,23.12,9.91Z"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1.5 -rotate-90" id="Outline" viewBox="0 0 24 24" width="20" height="20"><path d="M23.12,9.91,19.25,6a1,1,0,0,0-1.42,0h0a1,1,0,0,0,0,1.41L21.39,11H1a1,1,0,0,0-1,1H0a1,1,0,0,0,1,1H21.45l-3.62,3.61a1,1,0,0,0,0,1.42h0a1,1,0,0,0,1.42,0l3.87-3.88A3,3,0,0,0,23.12,9.91Z"/></svg>
                            </div>
                        </x-buttons.primary>
                    </div>
                    <div>
                        <x-buttons.primary id="applicant-add-bottom-to-top" onclick="assignAllApplicantsToSeats('bottom-to-top')" type="button" class="pl-2 py-2 z-10 w-10 h-10 rounded-lg fill-white">
                            <div class="absolute -ml-1 mt-0.5 flex">
                                <svg xmlns="http://www.w3.org/2000/svg" class="-rotate-90" id="Outline" viewBox="0 0 24 24" width="20" height="20"><path d="M23.12,9.91,19.25,6a1,1,0,0,0-1.42,0h0a1,1,0,0,0,0,1.41L21.39,11H1a1,1,0,0,0-1,1H0a1,1,0,0,0,1,1H21.45l-3.62,3.61a1,1,0,0,0,0,1.42h0a1,1,0,0,0,1.42,0l3.87-3.88A3,3,0,0,0,23.12,9.91Z"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1.5 -rotate-90" id="Outline" viewBox="0 0 24 24" width="20" height="20"><path d="M23.12,9.91,19.25,6a1,1,0,0,0-1.42,0h0a1,1,0,0,0,0,1.41L21.39,11H1a1,1,0,0,0-1,1H0a1,1,0,0,0,1,1H21.45l-3.62,3.61a1,1,0,0,0,0,1.42h0a1,1,0,0,0,1.42,0l3.87-3.88A3,3,0,0,0,23.12,9.91Z"/></svg>
                            </div>
                        </x-buttons.primary>
                    </div>
                    <div>
                        <x-buttons.primary id="applicant-add-alternate-bottom-top" onclick="assignAllApplicantsToSeats('alternate-bottom-top')" type="button" class="pl-2 py-2 z-10 w-10 h-10 rounded-lg fill-white">
                            <div class="absolute -ml-1 mt-0.5 flex">
                                <svg xmlns="http://www.w3.org/2000/svg" class="-rotate-90" id="Outline" viewBox="0 0 24 24" width="20" height="20"><path d="M23.12,9.91,19.25,6a1,1,0,0,0-1.42,0h0a1,1,0,0,0,0,1.41L21.39,11H1a1,1,0,0,0-1,1H0a1,1,0,0,0,1,1H21.45l-3.62,3.61a1,1,0,0,0,0,1.42h0a1,1,0,0,0,1.42,0l3.87-3.88A3,3,0,0,0,23.12,9.91Z"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1.5 rotate-90" id="Outline" viewBox="0 0 24 24" width="20" height="20"><path d="M23.12,9.91,19.25,6a1,1,0,0,0-1.42,0h0a1,1,0,0,0,0,1.41L21.39,11H1a1,1,0,0,0-1,1H0a1,1,0,0,0,1,1H21.45l-3.62,3.61a1,1,0,0,0,0,1.42h0a1,1,0,0,0,1.42,0l3.87-3.88A3,3,0,0,0,23.12,9.91Z"/></svg>
                            </div>
                        </x-buttons.primary>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

</script>