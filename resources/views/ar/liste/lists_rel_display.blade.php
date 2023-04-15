@php use App\Models\Eventi; @endphp
@php use App\Models\User;use Carbon\Carbon; @endphp
@php use Illuminate\Support\Facades\DB; @endphp
@extends('../../ar/layouts/layout')

@section('title', 'AR | Liste')
@section('content')
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="list"></i></div>
                            Liste
                        </h1>
                        Liste &middot; {{$lists->count()}} totali
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
                In manutenzione...
                {{--<form class="form mb-4 mt-2" action="{{route('lv_a.lists.search')}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="input-group mb-3">
                            <label for="input_evento"></label>
                            <input class="form-control rounded-start" list="browser" name="evento" id="input_evento"
                                   placeholder="Seleziona un evento...">
                            <datalist id="browser">
                                <option value=""></option>
                                <?php
                                $opt_arr = Eventi::getEvents();
                                foreach ($opt_arr as $opt) {
                                    echo '<option value="' . $opt->id . '">' . $opt->titolo . ' - ' . $opt->discoteca . ' ' . Carbon::parse($opt->date)->format('d/m/Y') . '</option>';
                                } ?>
                            </datalist>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>&nbsp;Cerca
                            </button>
                            <a type="button" class="btn btn-dark" href="{{route('lv_a.lists.all')}}">
                                Cancella filtro
                            </a>
                        </div>
                    </div>
                </form>
                <div class="card mb-4 mt-2">
                    <div class="card-header">
                        Tutte le liste per tutti gli eventi
                    </div>
                    <div class="card-body">
                        @if(!count($lists))
                            <div class="card-text text-center">Nessuna lista per questo evento</div>
                        @else
                            <div class="row row-cols-1 row-cols-sm-1 row-cols-md-3 row-cols-lg-4 g-4">
                                @foreach($lists as $list)
                                    @php($event = Eventi::getEvento($list->event_id)->values()->get(0))
                                    <div class="col">
                                        <div class="card h-100">
                                            <div class="card-header text-center">
                                                {{$event->titolo}} - {{Carbon::parse($event->date)->format('d/m/Y')}}
                                            </div>
                                            <div class="card-body">
                                                <h3 class="card-title"><strong>{{$list->surname}} {{$list->name}}</strong></h3>
                                                <h6 class="card-subtitle mb-2 text-muted">{{User::getUserById($list->fatto_da)->values()->get(0)->username}}</h6>
                                                <p class="card-text">
                                                    <span>Persone nella lista: {{$list->quantity}}</span>
                                                </p>
                                            </div>
                                            <div class="card-footer text-center">
                                                <a class="btn btn-primary mb-2"
                                                   href="{{route('lv_a.events.edit', $event->id)}}"
                                                   role="button" data-bs-toggle="edit-modal"
                                                   data-bs-target="#exampleModal">
                                                    Evento
                                                </a>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a class="btn btn-success mb-2 edit-btn"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#edit-modal"
                                                       data-link="{{route('lv_a.lists.edit', $list->id)}}"
                                                       data-name="{{$list->name}}"
                                                       data-surname="{{$list->surname}}"
                                                       data-quantity="{{$list->quantity}}"
                                                       data-entered="{{$list->entered}}"
                                                       data-id="{{$list->id}}"
                                                       data-user="{{$list->fatto_da}}"
                                                       role="button">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a class="btn btn-danger mb-2 delete-btn"
                                                       data-link="{{route('lv_a.lists.delete', $list->id)}}"
                                                       data-descrizione="Vuoi eliminare la lista <strong>{{$list->surname}} {{$list->surname}}</strong>?"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#delete-modal"
                                                       role="button">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>--}}
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- Edit Member Modal -->
    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifica lista</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <form action="" method="POST" id="editForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <label for="inputName" class="form-label">Nome lista</label>
                        <div class="mb-3 input-group">
                            <span class="input-group-text bg-gray-300" id="addon-wrapping">Cognome e nome</span>
                            <input type="text" class="form-control" name="surname"
                                   id="inputSurname" placeholder="Rossi">
                            <input type="text" class="form-control" name="name"
                                   id="inputName" placeholder="Mario">
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="inputPersone" class="form-label">Persone</label>
                                <input type="text" class="form-control" id="inputPersone"
                                       name="quantity" placeholder="100" aria-label="100">
                            </div>
                            <div class="col">
                                <label for="inputEntrate" class="form-label">Entrate effettive</label>
                                <input type="text" class="form-control" id="inputEntrate"
                                       name="entered" placeholder="100" aria-label="100">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="inputFattoDa" class="form-label">Fatto da</label>
                            <input type="text" class="form-control" name="fatto_da"
                                   id="inputFattoDa" placeholder="Mario Rossi" list="fattoDa">
                            <datalist id="fattoDa">
                                @php($users = DB::table('users')->get())
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->username}}
                                        - {{$user->name}} {{$user->surname}}
                                @endforeach
                            </datalist>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Procedi</button>
                        <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Annulla
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Conferma</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <form action="" method="GET" id="deleteForm">
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
    <script type="text/javascript">
        $(document).on('click', '.edit-btn', function () {
            let link = $(this).data('link');
            let name = $(this).data('name');
            let surname = $(this).data('surname');
            let quantity = $(this).data('quantity');
            let entered = $(this).data('entered');
            let id = $(this).data('id');
            let fatto_da = $(this).data('user');
            console.log(fatto_da);
            $('#editForm').attr('action', link);
            $('#editForm #id').val(id);
            $('#editForm #inputName').val(name);
            $('#editForm #inputSurname').val(surname);
            $('#editForm #inputPersone').val(quantity);
            $('#editForm #inputEntrate').val(entered);
            $('#editForm #inputFattoDa').val(fatto_da);
        });
        $(document).on('click', '.delete-btn', function () {
            let link = $(this).data('link');
            let descrizione = $(this).data('descrizione');
            console.log(descrizione);
            $('#deleteForm').attr('action', link);
            $('#deleteForm #descrizione').html(descrizione);
        });
    </script>
@endsection
