@extends('../../ar/layouts/layout')

@section('title', 'AR | Eventi')
@section('link')
    <style>
        @media (max-width: 1200px) {
            #calendarBtn {
                display: none;
            }

            #calendar {
                display: none;
            }
        }
        @media (max-width: 425px) {
            #data_modified {
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
            <div class="col-xl-12 col-md-12">
                <!-- Nav Event-->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="inArrivo-tab" data-bs-toggle="tab" href="#inArrivo"
                           data-bs-target="#inArrivo" role="tab" aria-controls="inArrivo" aria-selected="true">In arrivo
                            ({{$eventsNext->count()}})</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="passati-tab" data-bs-toggle="tab" href="#passati"
                           data-bs-target="#passati" role="tab" aria-controls="passati" aria-selected="false">Passati
                            ({{$eventsOld->count()}})</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="jolly-tab" data-bs-toggle="tab" href="#jolly"
                           data-bs-target="#jolly" role="tab" aria-controls="jolly" aria-selected="false">Jolly
                            ({{$jollyEvents->count()}})</a>
                    </li>
                </ul>

                <!-- Display Event-->
                <div class="tab-content" id="myTabContent">
                    <!-- In arrivo-->
                    <div class="tab-pane fade show active" id="inArrivo" role="tabpanel" aria-labelledby="inArrivo-tab">
                        <br>
                        <div class="row row-cols-1 row-cols-sm-1 row-cols-md-3 row-cols-lg-4 g-4" data-gridList="grid" style="display: none">
                            @foreach($eventsNext as $event)
                                @include('ar.event.event_card_vertical')
                            @endforeach
                        </div>
                        <div class="row" data-gridList="list" style="display: none">
                            @foreach($eventsNext as $event)
                                @include('ar.event.event_card_horizontal')
                            @endforeach
                        </div>
                    </div>

                    <!-- Passati-->
                    <div class="tab-pane fade" id="passati" role="tabpanel" data-gridList="grid"
                         aria-labelledby="passati-tab">
                        <br>
                        <div class="row row-cols-1 row-cols-sm-1 row-cols-md-3 row-cols-lg-4 g-4" data-gridList="grid" style="display: none">
                            @foreach($eventsOld as $event)
                                @if(strtotime($event->date) < strtotime('now') && $event->isJolly != 1)
                                    @include('ar.event.event_card_vertical')
                                @endif
                            @endforeach
                        </div>
                        <div class="row" data-gridList="list" style="display: none">
                            @foreach($eventsOld as $event)
                                @if(strtotime($event->date) < strtotime('now') && $event->isJolly != 1)
                                    @include('ar.event.event_card_horizontal')
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Jolly-->
                    <div class="tab-pane fade" id="jolly" role="tabpanel" data-gridList="grid"
                         aria-labelledby="jolly-tab">
                        <br>
                        <div class="row row-cols-1 row-cols-sm-1 row-cols-md-3 row-cols-lg-4 g-4" data-gridList="grid" style="display: none">
                            @foreach($jollyEvents as $event)
                                @include('ar.event.event_card_vertical')
                            @endforeach
                        </div>
                        <div class="row" data-gridList="list" style="display: none">
                            @foreach($jollyEvents as $event)
                                @include('ar.event.event_card_horizontal')
                            @endforeach
                        </div>
                    </div>
                </div>
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
    <!-- Countdown -->
    <script type="text/javascript" src="//cdn.rawgit.com/hilios/jQuery.countdown/2.1.0/dist/jquery.countdown.min.js">
    </script>
    <script type="text/javascript">
        $(function () {
            $('.countdown').each(function () {
                $(this).countdown($(this).attr('value'), function (event) {
                    $(this).text(
                        event.strftime('%Dd %Hh %Mm %Ss')
                    );
                });
            });
        });
        let hash = window.location.hash.substr(1);
        if (hash === 'grid')
            gridView();
        else if (hash === 'list')
            listView()
        else
            gridView();

        // List View
        function listView() {
            $('.row[data-gridList = "grid"]').css('display', 'none');
            $('.row[data-gridList = "list"]').css('display', '');
        }

        // Grid View
        function gridView() {
            $('.row[data-gridList = "grid"]').css('display', '');
            $('.row[data-gridList = "list"]').css('display', 'none');
        }

        $(document).ready(function(){
            $('#eventModal').on('show.bs.modal', function (e) {
                const rowid = $(e.relatedTarget).data('bs-id');
                let event = {!! $events !!};
                for (let i = 0; i < event.length; i++) {
                    let id = event[i].id;
                    if (id == rowid) {
                        event = event[i];
                        break;
                    }
                }
                const date = new Date(event.date);
                const day = date.toLocaleString('it-it', {weekday:'long'});
                $('#eventModal .modal-body #title').text(event.titolo);
                $('#eventModal .modal-body #extra').text(event.extra);
                $('#eventModal .modal-body #dateDay').text(day);
                $('#eventModal .modal-body #date').text(date.getDate()+"/"+(date.getMonth()+1)+"/"+date.getFullYear());
                $('#eventModal .modal-body #hour').text(date.getHours()+":"+date.getMinutes());
                $('#eventModal .modal-body #descrizione').html((event.descrizione !== "<p><br></p>") ? event.descrizione : "Descrizione non aggiunta");
                $('#eventModal .modal-body #discoteca').text(event.discoteca);
                $('#eventModal .modal-body #image').attr('src', '{{asset('assets/img/events').'/'}}'+event.image);
            });
        });
    </script>
@endsection
