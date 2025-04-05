@extends('admin.layouts.base')

@section('content')

    <style>
        /* Use a clean, minimal font similar to Google Calendar */
        .fc {
            font-family: Roboto, Arial, sans-serif;
        }
        /* Toolbar and title styling */
        .fc .fc-toolbar {
            background: #fff;
            border-bottom: 1px solid #e0e0e0;
        }
        .fc .fc-toolbar-title {
            color: #202124;
            font-size: 1.25rem;
        }
        /* Day numbers and headers */
        .fc .fc-daygrid-day-number {
            color: #202124;
        }
        .fc th {
            background: #f1f3f4;
            color: #5f6368;
        }
        /* Today's background */
        .fc .fc-day-today {
            background-color: #e8f0fe;
        }
        /* Event styling to mimic Google Calendar look */
        .fc-event {
            background-color: #4285F4 !important;
            border: none !important;
            color: #fff !important;
            font-weight: 500;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            padding: .5em .5em;
        }
        .fc-event:hover {
            background-color: #3367D6 !important;
        }
    </style>

    <div class="block full">
         <div id="calendar"></div>
    </div>

@endsection



@push('extrascripts')

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var gigs = @json($gigs);

            // Map gigs to FullCalendar events
            var events = gigs.map(function(gig) {
                return {
                    title: gig.client.client_name + ' ' + gig.client.client_last_name + ' / #' + gig.gig_cryptic + ' ($' + gig.gig_price + ')',
                    start: gig.start_datetime,
                    extendedProps: {
                        serial_number: gig.serial_number,
                        machine_model: gig.machine ? gig.machine.model_number : '',
                        machine_brand: gig.machine ? gig.machine.brand_name : '',
                        machine_type: gig.machine ? gig.machine.machine_type : '',
                        client_name: gig.client ? gig.client.client_name + ' ' + gig.client.client_last_name : '',
                        tech_name: gig.technician ? gig.technician.name : ''
                    }
                };
            });

            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: events,
                eventClick: function(info) {
                    alert(
                        'Client: ' + info.event.extendedProps.client_name + '\n' +
                        'Gig: ' + info.event.title + '\n' +
                        'Technician: ' + info.event.extendedProps.tech_name + '\n' +
                        'Serial Number: ' + info.event.extendedProps.serial_number + '\n' +
                        'Machine: ' + info.event.extendedProps.machine_brand + ' ' +
                                      info.event.extendedProps.machine_model + ' (' +
                                      info.event.extendedProps.machine_type + ')'
                    );
                }
            });
            calendar.render();
        });
    </script>

@endpush
