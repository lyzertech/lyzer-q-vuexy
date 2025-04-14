@extends('layouts/layoutMaster')

@section('title', 'Fullcalendar - Apps')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/fullcalendar/fullcalendar.scss', 'resources/assets/vendor/libs/flatpickr/flatpickr.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/quill/editor.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/app-calendar.scss'])
@endsection

@section('vendor-script')
    <!-- FullCalendar Core -->
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/index.global.min.js"></script>

    <!-- Required Plugins -->
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/list@6.1.8/index.global.min.js"></script> <!-- ✅ Add List Plugin -->

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/main.min.css" rel="stylesheet">
@endsection

@section('page-script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar_new');

            if (calendarEl) {
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth', // Default view
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,listMonth'
                    },
                    height: 710, // Set max height to 200px
                    firstDay: 1, // Start week on Monday
                    selectable: true,
                    editable: false,
                    droppable: false,
                    events: '/crm/calendar/data', // Fetch events from Laravel API
                    eventClassNames: function(info) {
                        return calendar.view.type === 'dayGridMonth' ? ['day-grid-event'] : [];
                    }
                });

                calendar.render();
            }
        });
    </script>
@endsection

<style>
    .day-grid-event {
        background-color: #3EAEED !important;
        color: #fff !important;
        border-color: #c70039 !important;
    }
</style>

@section('content')
    <script>
        console.log("FullCalendar:", typeof FullCalendar); // Should not be "undefined"
    </script>

    <div class="col-10 mx-auto">
        <div class="card app-calendar-wrapper">
            <div class="row d-flex g-0">
                <!-- Calendar & Modal -->
                <div class="col app-calendar-content">
                    <div class="card shadow-none border-0">
                        <div class="card-body pb-0">
                            <!-- FullCalendar -->
                            <div id="calendar_new"></div>
                        </div>
                    </div>
                </div>
                <!-- /Calendar & Modal -->
            </div>
        </div>
    </div>
@endsection
