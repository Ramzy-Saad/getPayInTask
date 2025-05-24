<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.css" rel="stylesheet" />

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="dropdown mb-3">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="statusDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Filter by Status
                </button>
                <ul class="dropdown-menu" aria-labelledby="statusDropdown">
                    <li><a class="dropdown-item" href="{{ route('dashboard') }}">All</a></li>
                    <li><a class="dropdown-item" href="{{ route('dashboard', ['status' => 'draft']) }}">Draft</a></li>
                    <li><a class="dropdown-item" href="{{ route('dashboard', ['status' => 'scheduled']) }}">Scheduled</a></li>
                    <li><a class="dropdown-item" href="{{ route('dashboard', ['status' => 'published']) }}">Published</a></li>
                </ul>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
    
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');   
            var events = @json($events); 
            if (calendarEl) {
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    events: events,
                });
    
                calendar.render();
            }
        });
    </script>
    
</x-app-layout>