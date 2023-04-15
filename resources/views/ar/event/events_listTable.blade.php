@php use Carbon\Carbon; @endphp
@extends('../../ar/layouts/layout')

@section('title', 'AR | Eventi')
@section('link')
    <link href="{{asset('assets/bootstrap/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/bootstrap/css/responsive.bootstrap5.min.css')}}" rel="stylesheet">
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
    <div class="container-fluid px-4">
        <div class="card">
            <div class="card-body">
                <div class="datatable">
                    <table class="table table-bordered table-hover table-striped text-center display rounded nowrap"
                           id="example">
                        <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Titolo</th>
                            <th>Extra</th>
                            <th>Data</th>
                            <th>Tavoli</th>
                            <th>Pagati</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($events))
                            @php ($c = 1)
                            @foreach($events as $event)
                                @if($event->isJolly == 0)
                                    <tr>
                                        <td>{{$c++}}</td>
                                        <td class="text-uppercase">{!! $event->titolo !!}</td>
                                        <td>{!! $event->extra !!}</td>
                                        <td data-sort='{{Carbon::parse($event->date)}}'>{{Carbon::parse($event->date)->format('d/m/Y')}}</td>
                                        <td>{{DB::table('tavoli_eventi')->where('event_id', $event->id)->count()}}</td>
                                        <td>{!! $event->pagato ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                        <td>{!! $event->active ? '<div class="badge bg-success text-white rounded-pill">Attivo</div>' : '<div class="badge bg-danger text-white rounded-pill">Non attivo</div>'!!}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                @if(!$event->isJolly)
                                                    <a class="btn btn-warning mb-2"
                                                       href="{{route('tavoli.event', ['id' => $event->id])}}">
                                                        <i class="fas fa-glass-martini-alt"></i></a>
                                                    <a class="btn btn-success mb-2"
                                                       href="{{route('liste.event', ['id' => $event->id])}}">
                                                        <i class="fa-solid fa-list-check"></i>
                                                    </a>
                                                @endif
                                                @if($event->active)
                                                    <a class="btn btn-secondary mb-2" target="_blank"
                                                       href="{{route('singleEvent', [$event->id])}}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @else
                                                    <button type="button" class="btn btn-info mb-2"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#eventModal"
                                                            data-bs-id="{{$event->id}}">
                                                        <i class="fa-solid fa-magnifying-glass"></i>
                                                    </button>
                                                @endif
                                                <a class="btn btn-primary mb-2"
                                                   href="{{route('events.edit', ['id' => $event->id])}}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <!-- //Table -->
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
                                    <img src="{{asset('assets/img/events/event_placeholder.webp')}}"
                                         class="img-fluid event-image mx-auto" alt="Immagine evento" id="image">
                                    <div class="card-body">
                                        <h2 class="card-title title-event" id="title"></h2>
                                        <h5 class="text-muted extra" id="extra"></h5>
                                        <p class="card-text discoteca"><i class="fas fa-map-marker-alt"></i> <span
                                                id="discoteca"></span></p>
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
        const hash = window.location.hash.substr(1);
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
    </script>

    <script type="text/javascript" src="{{asset('assets/bootstrap/js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/bootstrap/js/dataTables.bootstrap5.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/bootstrap/js/dataTables.responsive.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#example').DataTable({
                lengthMenu: [10, 20, 30, 40, 50],
                responsive: true,
                ordering: true,
                paging: true,
                info: true,
                searching: true,
                columns: [
                    {orderable: false},
                    null,
                    {orderable: false},
                    null,
                    {orderable: false},
                    {orderable: false},
                    null,
                    {orderable: false}
                ],
                columnDefs: [
                    {responsivePriority: 1, targets: 0},
                    {responsivePriority: 2, targets: 1},
                    {responsivePriority: 3, targets: 7},
                    {responsivePriority: 4, targets: 2},
                    {responsivePriority: 5, targets: 3},
                    {responsivePriority: 6, targets: 4},
                    {responsivePriority: 10001, targets: 5},
                    {responsivePriority: 10002, targets: 6}
                ]
            });
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
                const day = date.toLocaleString('it-it', {weekday: 'long'});
                $('#eventModal .modal-body #title').text(event.titolo);
                $('#eventModal .modal-body #extra').text(event.extra);
                $('#eventModal .modal-body #dateDay').text(day);
                $('#eventModal .modal-body #date').text(date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear());
                $('#eventModal .modal-body #hour').text(date.getHours() + ":" + date.getMinutes());
                $('#eventModal .modal-body #descrizione').html((event.descrizione !== "<p><br></p>") ? event.descrizione : "Descrizione non aggiunta");
                $('#eventModal .modal-body #discoteca').text(event.discoteca);
                $('#eventModal .modal-body #image').attr('src', '{{asset('assets/img/events').'/'}}' + event.image);
            });
        });
    </script>
@endsection
