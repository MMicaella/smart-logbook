<x-app-layout>

<style>
    /* ===============================
        BACKGROUND
    =============================== */

    .min-h-screen.bg-gray-100 {
        background: transparent !important;
    }

    body {
        margin: 0;
        padding: 0;

        background:
            linear-gradient(rgba(25,0,0,0.82), rgba(0,0,0,0.92)),
            url('{{ asset('images/osmena-logo.png') }}');

        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
    }

    header {
        background: transparent !important;
        box-shadow: none !important;
    }

    /* ===============================
        GLASS EFFECTS
    =============================== */

    .glass-card {
        background: rgba(255,255,255,0.08);
        backdrop-filter: blur(18px);
        border-radius: 22px;
        border: 1px solid rgba(255,255,255,0.12);
        box-shadow: 0 10px 40px rgba(0,0,0,0.35);
    }

    .glass-header {
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 18px;
        padding: 18px 22px;
        backdrop-filter: blur(15px);
        color: white;
    }

    /* ===============================
        FULLCALENDAR GLOBAL TEXT FIX
    =============================== */

    .fc {
        color: white !important;
    }

    /* ✅ WEEKDAY HEADER FIX (REAL FIX) */
    .fc .fc-col-header-cell,
    .fc .fc-col-header-cell-cushion,
    .fc .fc-col-header-cell-cushion a,
    .fc-theme-standard th {
        color: white !important;
        background: rgba(255,255,255,0.08) !important;
        font-weight: 700 !important;
        text-decoration: none !important;
        border-color: rgba(255,255,255,0.15) !important;

        /* IMPORTANT FIX FOR VISIBILITY */
        opacity: 1 !important;
        visibility: visible !important;
    }

    /* FORCE CENTER TEXT */
    .fc .fc-col-header-cell-cushion {
        display: block !important;
        padding: 10px 0 !important;
        text-align: center !important;
        color: white !important;
    }

    /* ===============================
        CALENDAR BODY
    =============================== */

    .fc-daygrid-day {
        background: rgba(255,255,255,0.02);
    }

    .fc-daygrid-day-number {
        color: white !important;
    }

    .fc .fc-toolbar-title {
        color: white;
        font-weight: 700;
    }

    .fc-button {
        background: rgba(255,255,255,0.12) !important;
        border: 1px solid rgba(255,255,255,0.15) !important;
        color: white !important;
    }

    .fc-button:hover {
        background: rgba(255,255,255,0.2) !important;
    }

    /* ===============================
        MODAL
    =============================== */

    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.6);
        backdrop-filter: blur(6px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 50;
    }

    .modal-box {
        width: 100%;
        max-width: 520px;
        padding: 26px;
        border-radius: 22px;
        background: rgba(255,255,255,0.10);
        backdrop-filter: blur(18px);
        border: 1px solid rgba(255,255,255,0.15);
        color: white;
    }

    .modal-close {
        position: absolute;
        top: 12px;
        right: 14px;
        cursor: pointer;
        color: rgba(255,255,255,0.7);
    }

    .label {
        font-size: 12px;
        color: rgba(255,255,255,0.6);
    }

    .value {
        font-weight: 600;
        margin-bottom: 10px;
    }

</style>

<x-slot name="header">
    <div class="glass-header">
        <h2 class="text-2xl font-bold">Vehicle Booking Calendar</h2>
    </div>
</x-slot>

<div class="p-6">
    <div class="glass-card p-6">
        <div id="calendar"></div>
    </div>
</div>

<!-- MODAL -->
<div id="eventModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-close" onclick="closeModal()">✕</div>

        <h2 class="text-2xl font-bold mb-5">Booking Details</h2>

        <p class="label">Vehicle</p><p id="modalVehicle" class="value"></p>
        <p class="label">User</p><p id="modalUser" class="value"></p>
        <p class="label">Destination</p><p id="modalDestination" class="value"></p>
        <p class="label">Purpose</p><p id="modalPurpose" class="value"></p>
        <p class="label">Date & Time</p><p id="modalDate" class="value"></p>
        <p class="label">Status</p>
        <p id="modalStatus" class="inline-block px-3 py-1 rounded-full text-sm font-semibold"></p>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 'auto',

        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },

        events: @json($events),

        eventClick: function(info) {

            document.getElementById('eventModal').style.display = 'flex';

            document.getElementById('modalVehicle').innerText =
                info.event.extendedProps.vehicle;

            document.getElementById('modalUser').innerText =
                info.event.extendedProps.user;

            document.getElementById('modalDestination').innerText =
                info.event.extendedProps.destination;

            document.getElementById('modalPurpose').innerText =
                info.event.extendedProps.purpose;

            document.getElementById('modalDate').innerText =
                info.event.start.toLocaleString();

            let status = document.getElementById('modalStatus');
            status.innerText = info.event.extendedProps.status;
            status.className = '';

            if(info.event.extendedProps.status == 'approved'){
                status.className = 'bg-green-200 text-green-800 px-3 py-1 rounded-full';
            }
            else if(info.event.extendedProps.status == 'rejected'){
                status.className = 'bg-red-200 text-red-800 px-3 py-1 rounded-full';
            }
            else{
                status.className = 'bg-yellow-200 text-yellow-800 px-3 py-1 rounded-full';
            }
        }
    });

    calendar.render();
});

function closeModal(){
    document.getElementById('eventModal').style.display = 'none';
}
</script>

</x-app-layout>