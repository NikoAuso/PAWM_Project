@php use Carbon\Carbon; @endphp
@extends('ar.layouts.layout')

@section('title', 'AR | Profilo Utente')
@section('content')
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            {{$user->name}} {{$user->surname}}
                        </h1>
                    </div>
                    <div class="col-auto align-items-right mb-3">
                        <a class="btn btn-sm btn-light text-primary"
                           href="{{route('users.edit', ['id' => $user->id, 'page' => $user->getRoleNames()->get(0)])}}">
                            <i class="me-1" data-feather="edit"></i>
                            Modifica
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    @include('ar.layouts.message')
    <!-- Main page content-->
    <div class="container-xl px-4 mt-4">
        <hr class="mt-0 mb-4"/>
        <!-- Account page navigation-->
        <div class="row">
            <div class="col-xl-4">
                <!-- Profile picture card-->
                <div class="card mb-4">
                    <div class="card-header">Avatar</div>
                    <div class="card-body text-center">
                        <div class="image_area">
                            <label for="upload_image">
                                <img class="img-account-profile rounded-circle mb-2"
                                     src="{{asset('assets/img/avatar').'/'.$user->avatar}}" id="uploaded_image"
                                     alt="Immagine profilo {{$user->name}} {{$user->surname}}">
                            </label>
                        </div>
                    </div>
                </div>
                <!-- Account social card-->
                <div class="card mb-4">
                    <div class="card-header">Link social</div>
                    <div class="card-body">
                        @if(empty($user->account_instagram) && empty($user->account_facebook))
                            <span>Nessun link aggiunto</span>
                        @else
                            @if(!empty($user->account_facebook))
                                <a class="btn btn-outline-primary" type="button" href="{{$user->account_facebook}}"
                                   target="_blank">Facebook</a>
                            @endif
                            @if(!empty($user->account_instagram))
                                <a class="btn btn-outline-danger" type="button"
                                   href="{{$user->account_instagram}}" target="_blank">Instagram</a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <!-- Account details card-->
                <div class="card mb-4">
                    <div class="card-header">Dettagli account</div>
                    <div class="card-body">
                        <!-- Form (username)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputUsername">Username</label>
                            <div class="form-control" id="inputUsername" readonly>{{$user->username}}&nbsp</div>
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3">
                            <!-- Form Group (nome)-->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputFirstName">Nome</label>
                                <div class="form-control" id="inputFirstName" readonly>{{$user->name}}&nbsp;</div>
                            </div>
                            <!-- Form Group (cognome)-->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputLastName">Cognome</label>
                                <div class="form-control" id="inputLastName" readonly>{{$user->surname}}&nbsp;</div>
                            </div>
                        </div>
                        <!-- Form Row-->
                        <div class="mb-3">
                            <!-- Form Group (email)-->
                            <label class="small mb-1" for="inputEmail">Email</label>
                            <div class="form-control" id="inputEmail" readonly>{{$user->email}}&nbsp;</div>
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3">
                            <!-- Form Group (birthday)-->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="date">Data di nascita</label>
                                <div class="form-control" readonly
                                     id="date">{{(!empty($user->birthday)) ? (Carbon::parse($user->birthday)->format('d/m/Y')) : ''}}
                                </div>
                            </div>
                            <!-- Form Group (phone)-->
                            <div class="col-md-6 mb-3">
                                <label class="small mb-1" for="inputPhone">Cellulare</label>
                                <div class="form-control" id="inputPhone" readonly>{{$user->phone}}&nbsp;</div>
                            </div>
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3">
                            <!-- Form Group (address)-->
                            <div class="col-md-4 mb-3">
                                <label class="small mb-1" for="inputAddress">Indirizzo</label>
                                <div class="form-control" id="inputAddress" readonly>{{$user->address}}&nbsp;</div>
                            </div>
                            <!-- Form Group (ruolo)-->
                            <div class="col-md-4 mb-3">
                                <label class="small mb-1" for="inputRuolo">Ruolo</label>
                                <div class="form-control text-capitalize" id="inputRuolo" readonly>{{$user->getRoleNames()->get(0)}}
                                    &nbsp;
                                </div>
                            </div>
                            <!-- Form Group (Team)-->
                            <div class="col-md-4 mb-3">
                                <label class="small mb-1" for="inputTeam">Team</label>
                                <div class="form-control" id="inputTeam" readonly>{{$user->team}}&nbsp;</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
