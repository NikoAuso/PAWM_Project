@extends('../../ar/layouts/layout')

@section('title', 'AR | Eventi')
@section('link')
    <link href="{{asset('assets/fullcalendar/main.css')}}" rel="stylesheet">
    <style>
        @media (max-width: 1200px) {
            #calendarBtn {
                display: none;
            }

            #calendar {
                display: none;
            }
        }

        .event-image {
            max-height: 300px;
        }

        .title-event {
            font-size: 3rem;
            font-weight: 500;
            line-height: 1.2;
        }

        .extra {
            font-size: 1.25rem;
            font-weight: 500;
            line-height: 1.2;
        }

        .discoteca {
            font-size: 1.5rem;
            font-weight: bold;
            font-stretch: expanded;
            font-style: italic;
        }

        .data {
            font-size: 1.25rem;
            font-weight: bold
        }

        .descrizione {
            padding: 0 5px;
            font-size: 0.8rem;
        }
    </style>
@endsection
@section('content')
    @include('ar.event.header')
    @include('ar.layouts.message')
    <!-- Main page content-->
    <div class="container-xl px-4 mt-5">
        <div class="row">
            <div class="col-xl-12 col-md-6 mb-12">
                <div id='calendar' class="text-capitalize"></div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModal">Dettagli evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container bg-text">
                        <div class="row">
                            <!-- Blog entries-->
                            <div class="col-lg-7">
                                <!-- Featured blog post-->
                                <div class="card mb-4 text-center bg-transparent">
                                    <img src="{{asset('assets/img/events/event_placeholder.webp')}}" class="img-fluid event-image mx-auto" alt="Immagine evento" id="image">
                                    <div class="card-body">
                                        <h2 class="card-title title-event" id="title"></h2>
                                        <h5 class="text-muted extra" id="extra"></h5>
                                        <p class="card-text discoteca"><i class="fas fa-map-marker-alt"></i> <span id="discoteca"></span></p>
                                    </div>
                                </div>
                            </div>
                            <!-- Side widgets-->
                            <div class="col-lg-5">
                                <!-- Side widget-->
                                <div class="card mb-4 bg-transparent card-detail">
                                    <div class="card-header">Dettagli</div>
                                    <div class="card-body">
                                        <p class="text-capitalize data"><i class="far fa-calendar-alt"></i> <span
                                                    id="dateDay"></span>, <span id="date"></span></p>
                                        <p class="text-capitalize data"><i class="far fa-clock"></i> <span
                                                    id="hour"></span></p>
                                        <p class="descrizione fs-5" id="descrizione"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{asset('assets/fullcalendar/main.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/fullcalendar/locales-all.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: ''
                },
                locale: 'it',
                timeZone: 'UTC',
                selectable: true,
                dayMaxEvents: true, // allow "more" link when too many events
                eventTimeFormat: {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric',
                    weekday: 'short'
                },
                events: {!! $data !!},
                eventClick: function (info) {
                    let event = {!! $data !!};
                    for (let i = 0; i < event.length; i++) {
                        let id = event[i].id;
                        let idEvent = info.event._def.publicId;
                        if (id == idEvent) {
                            event = event[i];
                            break;
                        }
                    }
                    $('#eventModal .modal-body #title').text(event.title);
                    $('#eventModal .modal-body #extra').text(event.extra);
                    $('#eventModal .modal-body #dateDay').text(event.dateDay);
                    $('#eventModal .modal-body #date').text(event.dateFull);
                    $('#eventModal .modal-body #hour').text(event.dateHour);
                    $('#eventModal .modal-body #descrizione').html(event.descrizione);
                    $('#eventModal .modal-body #discoteca').text(event.discoteca);
                    $('#eventModal .modal-body #image').attr('src', '{{asset('assets/img/events').'/'}}'+event.immagine);
                    $('#eventModal').modal('show');
                }
            });
            calendar.render();
        });
    </script>

@endsection
