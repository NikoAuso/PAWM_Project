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
                    <div class="col-auto align-items-right mb-3">
                        <a class="btn btn-sm btn-light text-primary"
                           href="{{route('users.insert', ['page' => basename($_SERVER['REQUEST_URI'])])}}">
                            <i class="me-1" data-feather="plus"></i>
                            Aggiungi nuovo
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    @include('ar.layouts.message')
    <!-- Main page content-->
    <div class="container-xl px-4 mt-5">
        <div class="row">
            <div class="col-xl-12 col-sm-12 mb-12">
                <div class="card card-waves mb-4 mt-2">
                    <div class="card-header">Lista completa</div>
                    <div class="card-body">
                        <div class="datatable">
                            <table class="table table-bordered table-hover table-striped text-center display rounded nowrap" id="example">
                                <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>Username</th>
                                    <th>Status</th>
                                    <th>Email</th>
                                    <th>Team</th>
                                    <th>Telefono</th>
                                    <th>Indirizzo</th>
                                    <th>Data di nascita</th>
                                    <th>Ultimo accesso</th>
                                    <th>Modificato il</th>
                                    <th>Avatar</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($c = 1)
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{$c++}}</td>
                                        <td>{{$user->name}} {{$user->surname}}</td>
                                        <td>{{$user->username}}</td>
                                        <td>{!! ($user->active == 1) ? '<div class="badge bg-success text-white rounded-pill">Attivo</div>' : '<div class="badge bg-danger text-white rounded-pill">Non attivo</div>'!!}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->team}}</td>
                                        <td>{{$user->phone}}</td>
                                        <td>{{$user->address}}</td>
                                        <td>@if($user->birthday != null)
                                                {{Carbon::parse($user->birthday)->format('d/m/Y')}}
                                            @endif</td>
                                        <td>@if($user->lastaccess != null)
                                                {{Carbon::parse($user->lastaccess)->format('d-m-Y H:i:s')}}
                                            @endif
                                        </td>
                                        <td>{{Carbon::parse($user->updated_at)->format('d-m-Y H:i')}}</td>
                                        <td>
                                            <a href="#" class="avatar-btn" data-bs-toggle="modal"
                                               data-bs-target="#avatar-img"
                                               data-img="{{asset('assets/img/avatar')}}/{{$user->avatar}}">
                                                <img class="avatar" style="border-radius: 50%;" width="40px"
                                                     height="40px"
                                                     src="{{asset('assets/img/avatar')}}/{{$user->avatar}}" alt="">
                                            </a>
                                        </td>
                                        <td>
                                            @if(\Illuminate\Support\Facades\Auth::id() == $user->id)
                                                <span class="badge bg-secondary">YOU</span>
                                            @else
                                                <div class="btn-group" role="group">
                                                    <a type="button" class="btn btn-primary"
                                                       href="{{route('users.edit', ['id' => $user->id, 'page' => basename($_SERVER['REQUEST_URI'])])}}"><i
                                                            class="fas fa-edit"></i></a>
                                                    <a type="button" class="btn btn-secondary"
                                                       href="{{route('users.profile', ['id' => $user->id])}}"><i
                                                            class="fas fa-eye"></i></a>
                                                    <a type="button" href="#" class="btn btn-danger delete-btn"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#confirm-delete"
                                                       data-link="{{route('delete-user', ['id' => $user->id, 'page' => (basename($_SERVER['REQUEST_URI']))])}}"
                                                       data-descrizione="Sei sicuro di voler eliminare l'utente <strong>{{$user->username}}</strong>?">
                                                        <i class="fa-solid fa-user-slash"></i>
                                                    </a>
                                                </div>
                                            @endif
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
        </div>
    </div>
@endsection
@section('scripts')
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
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog"
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
                    {responsivePriority: 3, targets: 2},
                    {responsivePriority: 4, targets: 3},
                    {responsivePriority: 5, targets: 12},
                    {responsivePriority: 10001, targets: 5},
                    {responsivePriority: 10002, targets: 6},
                    {responsivePriority: 10003, targets: 7},
                    {responsivePriority: 10004, targets: 8},
                    {responsivePriority: 10005, targets: 9},
                    {responsivePriority: 10006, targets: 10},
                    {responsivePriority: 10007, targets: 11},
                    {responsivePriority: 10008, targets: 4}
                ]
            });
            $(document).on('click', '.avatar-btn', function () {
                let avatar = $(this).data('img');
                $('#avatar-img-modal').attr('src', avatar);
            });
            $(document).on('click', '.delete-btn', function () {
                let link = $(this).data('link');
                let descrizione = $(this).data('descrizione');
                console.log(descrizione);
                $('#formSubmit').attr('action', link);
                $('#confirm-delete #descrizione').html(descrizione);
            })
        });
    </script>
@endsection
