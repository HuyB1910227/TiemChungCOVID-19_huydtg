@extends('layouts.EmployeeApp')

@section('title', 'Tiêm chủng')

@section('ex-css')
{{-- <link href="{{ asset('../node_modules/@fullcalendar/core/main.css') }}" rel="stylesheet" />
<link href="{{ asset('../node_modules/@fullcalendar/daygrid/main.css') }}" rel="stylesheet" />
<link href="{{ asset('../node_modules/@fullcalendar/timegrid/main.css') }}" rel="stylesheet" />
<link href="{{ asset('../node_modules/@fullcalendar/list/main.css') }}" rel="stylesheet" /> --}}
<link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
  
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script> --}}
  
{{-- <script src="
https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js
"></script> --}}
<script>

    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        // plugins: [ 'dayGrid', 'timeGrid', 'list' ],
        header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
        },
        displayEventEnd: true,
        locale: 'vi',
        events: '/tiemchungcovid19.vn/nhan-vien/chi-tiet-lich-lam-viec',
        eventClick: function(info) {
          window.location.href = '/tiemchungcovid19.vn/nhan-vien/lich-cong-tac/' + info.event.id;
        },
        eventTimeFormat: {
          hour: '2-digit',
          minute: '2-digit',
          hour12: false,
          meridiem: false
        },
      });
      
      calendar.render();
    });

  </script>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Lịch công tác</li>
  <li class="text-uppercase ml-auto font-weight-bold">Quản lý lịch làm việc</li>
    
    
@endsection
@section('main-content')
  {{-- <div class="row"> --}}
  <div class="m-3">
     <div class="bg-white card shadow">
      <div class="card-header ">
        <a class="btn btn-primary ml-3" href="{{route('employee.timetable')}}">
          <i class="fa-solid fa-calendar-days"></i>
        </a>       
      </div>
      <div class="card-body">
        <div id='calendar' class="m-2"> </div>
     </div>
    </div>
  </div>
   
    
  {{-- </div> --}}

@endsection

@section('ex-script')
{{-- <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js'></script> --}}
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js'></script>

<script>
    $(document).ready(function() {
        var SITEURL = "{{ url('/') }}";
  
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // $('#calendar').changeView('timeGrid', {
        //     start: '2017-06-01',
        //     end: '2017-06-05'
        //     });

        
    })
</script>
@endsection