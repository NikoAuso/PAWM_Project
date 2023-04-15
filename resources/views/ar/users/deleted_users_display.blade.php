@php use Carbon\Carbon; @endphp
@extends('../../ar/layouts/layout')

@section('title', "$title")
@section('link')
    <link href="{{asset('assets/bootstrap/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/bootstrap/css/responsive.bootstrap5.min.css')}}" rel="stylesheet">
    <style>
        td, th {
            vertical-align: middle;
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
                            {{$title}}
                        </h1>
                        Lista utenti &middot; {{$users->count()}} totali
                    </div>
                </div>
            </div>
        </div>
    </header>
    @include('ar.layouts.message')
    <!-- Main page content-->
    <div class="container-fluid px-4">
        <div class="card card-waves mb-4 mt-2">
            <div class="card-header">Lista completa</div>
            <div class="card-body">
                <div class="datatable">
                    <table class="table table-bordered table-hover rounded nowrap" id="example">
                        <thead class="thead-dark">
                        <tr class="text-center">
                            <th>#</th>
                            <th>Nome</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Ruolo</th>
                            <th>Status</th>
                            <th>Team</th>
                            <th>Telefono</th>
                            <th>Indirizzo</th>
                            <th>Data di nascita</th>
                            <th>Ultimo accesso:</th>
                            <th>Modificato il:</th>
                            <th>Avatar</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($c = 0)
                        @foreach($users as $user)
                            @php($c++)
                            <tr class="text-center">
                                <td>{{$c}}</td>
                                <td>{{$user->name}} {{$user->surname}}</td>
                                <td>{{$user->username}}</td>
                                <td>{{$user->email}}</td>
                                <td class="text-capitalize">{{$user->role}}</td>
                                <td>{!! ($user->active == 1) ? '<div class="badge bg-success text-white rounded-pill">Attivo</div>' : '<div class="badge bg-danger text-white rounded-pill">Non attivo</div>'!!}</td>
                                <td>{{$user->team}}</td>
                                <td>{{$user->phone}}</td>
                                <td>{{$user->address}}</td>
                                <td>@if($user->birthday != null)
                                        {{Carbon::parse($user->birthday)->format('d/m/Y')}}
                                    @endif</td>
                                <td>{{$user->lastaccess}}</td>
                                <td>{{Carbon::parse($user->updated_at)->format('d-m-Y H:i')}}</td>
                                <td>
                                    <a href="#" class="avatar-btn" data-bs-toggle="modal" data-bs-target="#avatar-img"
                                       data-img="{{asset('assets/img/avatar')}}/{{$user->avatar}}">
                                        <img class="avatar" style="border-radius: 50%;" width="40px" height="40px"
                                             src="{{asset('assets/img/avatar')}}/{{$user->avatar}}" alt="">
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="#" class="btn btn-success delete_btn" data-bs-toggle="modal"
                                           data-bs-target="#confirm"
                                           data-link="{{route('restore-user', $user->id)}}"
                                           data-descrizione="Vuoi riattivare l'utente <strong>{{$user->username}}</strong>?">
                                            <i class="fas fa-trash-restore"></i>
                                        </a>
                                        <a href="#" class="btn btn-danger delete_btn" data-bs-toggle="modal"
                                           data-bs-target="#confirm"
                                           data-link="{{route('definitely-delete-user', $user->id)}}"
                                           data-descrizione="Sei sicuro di voler eliminare <strong>DEFINITIVAMENTE</strong>
                                                            l'utente <strong>{{$user->username}}</strong>?
                                                            L'eliminazione dell'utente comporterà l'eliminazione dei tavoli
                                                            da lui fatti.</br>Consigliamo prima di
                                                            <a href='{{route('tavoli')}}'>chiudere la  stagione</a>.">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
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
    <div class="modal fade" id="confirm" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Conferma</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <form action="" method="POST" id="formSubmit">
                    @csrf
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
    <!-- Avatar Modal -->
    <div class="modal fade" id="avatar-img" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Avatar dell'utente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img class="img-responsive modal-content"
                         src="" id="avatar-img-modal"
                         alt="Immagine profilo">
                </div>
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
                ordering: true,
                paging: true,
                info: true,
                searching: true,
                responsive: true,
                columns: [
                    {orderable: true},
                    {orderable: true},
                    {orderable: true},
                    {orderable: true},
                    {orderable: false},
                    {orderable: true},
                    {orderable: false},
                    {orderable: false},
                    {orderable: false},
                    {orderable: false},
                    {orderable: false},
                    {orderable: false},
                    {orderable: false},
                    {orderable: false}
                ],
                columnDefs: [
                    {responsivePriority: 1, targets: 0},
                    {responsivePriority: 2, targets: 1},
                    {responsivePriority: 3, targets: 13},
                    {responsivePriority: 4, targets: 2},
                    {responsivePriority: 5, targets: 3},
                    {responsivePriority: 6, targets: 4},
                    {responsivePriority: 10001, targets: 5},
                    {responsivePriority: 10002, targets: 6},
                    {responsivePriority: 10003, targets: 7},
                    {responsivePriority: 10004, targets: 8},
                    {responsivePriority: 10005, targets: 9},
                    {responsivePriority: 10006, targets: 10},
                    {responsivePriority: 10007, targets: 11},
                    {responsivePriority: 10008, targets: 12}
                ]
            });
            $(document).on('click', '.avatar-btn', function () {
                let avatar = $(this).data('img');
                $('#avatar-img-modal').attr('src', avatar);
            });
            $(document).on('click', '.delete_btn', function () {
                let link = $(this).data('link');
                let descrizione = $(this).data('descrizione');
                $('#formSubmit').attr('action', link);
                $('#confirm #descrizione').html(descrizione);
            })
        });
    </script>
@endsection
