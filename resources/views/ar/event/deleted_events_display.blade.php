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
        }
    </style>
@endsection
@section('content')
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="list"></i></div>
                            Eventi eliminati
                        </h1>
                        Lista eventi &middot; {{$deletedEvents->count()}} totali
                    </div>
                </div>
            </div>
        </div>
    </header>
    @include('ar.layouts.message')
    <!-- Main page content-->
    <div class="container-fluid px-4">
        <div class="card">
            <div class="card-body">
                <div class="datatable">
                    <table class="table table-bordered table-hover table-striped text-center display rounded"
                           id="example">
                        <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Titolo</th>
                            <th>Extra</th>
                            <th>Data</th>
                            <th>Tavoli</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($deletedEvents))
                            @php ($c = 1)
                            @foreach($deletedEvents as $event)
                                <tr>
                                    <td>{{$c++}}</td>
                                    <td class="text-uppercase">{!! $event->titolo !!}</td>
                                    <td>{!! $event->extra !!}</td>
                                    <td>{{Carbon::parse($event->date)->format('d/m/Y')}}</td>
                                    <td>{{DB::table('tavoli_eventi')->where('event_id', $event->id)->count()}}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="#" class="btn btn-success delete_btn" data-bs-toggle="modal"
                                               data-bs-target="#confirm-delete"
                                               data-link="{{route('restore-event', ['id' => $event->id])}}"
                                               data-descrizione="Vuoi ripristinare l'evento <strong>{{$event->titolo}}</strong>?">
                                                <i class="fas fa-trash-restore"></i>
                                            </a>
                                            <a href="#" class="btn btn-danger delete_btn" data-bs-toggle="modal"
                                               data-bs-target="#confirm-delete"
                                               data-link="{{route('definitely-delete-event', [$event->id])}}"
                                               data-descrizione="Sei sicuro di voler eliminare <strong>DEFINITIVAMENTE</strong>
                                                                    l'evento <strong>{{$event->titolo}}</strong>?">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
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
    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog"
         aria-labelledby="confirmDeleteModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Conferma</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <form action="" method="GET" id="formSubmit">
                    <div class="modal-body">
                        <p id="descrizione"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Si</button>
                        <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">No
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Page level plugins -->
    <script type="text/javascript" src="{{asset('assets/bootstrap/js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/bootstrap/js/dataTables.bootstrap5.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/bootstrap/js/dataTables.responsive.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#example').DataTable({
                responsive: true,
                paging: true,
                info: true,
                searching: true,
                ordering: false,
                columns: [
                    {orderable: true},
                    null,
                    {orderable: false},
                    null,
                    {orderable: false},
                    {orderable: false}
                ],
                columnDefs: [
                    {responsivePriority: 1, targets: 0},
                    {responsivePriority: 2, targets: 1},
                    {responsivePriority: 3, targets: 5},
                    {responsivePriority: 4, targets: 2},
                    {responsivePriority: 5, targets: 3},
                    {responsivePriority: 6, targets: 4},
                ]
            });
            $(document).on('click', '.delete_btn', function () {
                let link = $(this).data('link');
                let descrizione = $(this).data('descrizione');
                $('#formSubmit').attr('action', link);
                $('#confirm-delete #descrizione').html(descrizione);
            })
        });
    </script>
@endsection
