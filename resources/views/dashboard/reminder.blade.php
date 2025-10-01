@extends('layouts.app')

@section('title', 'Jadwal Nasabah')

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <h3 class="page-title">Jadwal Nasabah</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Jadwal Nasabah</li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                editable: false,
                events: @json($events),
                eventRender: function(event, element) {
                    if (event.className) {
                        element.addClass(event.className); // menambahkan warna
                    }
                }
            });
        });
    </script>
@endsection
