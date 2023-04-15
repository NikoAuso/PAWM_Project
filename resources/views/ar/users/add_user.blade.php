@extends('../../ar/layouts/layout')

@section('title', 'Utenti')
@section('link')
    <link href="{{asset('assets/bootstrap/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/bootstrap/css/responsive.bootstrap5.min.css')}}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
          rel="stylesheet">
@endsection
@section('content')
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="file-text"></i></div>
                            Inserisci utente
                        </h1>
                    </div>
                    <div class="col-12 col-lg-auto mb-3">
                        @php $page_url = 'users.'.$page; @endphp
                        <a class="btn btn-sm btn-light text-primary" href="{{route($page_url)}}">
                            <i class="me-1" data-feather="arrow-left"></i>
                            Torna a tutti gli utenti
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    @include('ar.layouts.message')
    <!-- Main page content-->
    <form action="{{route('create-user', ['page' => $page])}}" method="post" id="customer_form"
          enctype="multipart/form-data">
        @csrf
        <div class="container-xl px-4 mt-4">
            <div class="row">
                <div class="col-xl-4">
                    <!-- Profile picture card-->
                    <div class="card mb-4 mb-xl-0">
                        <div class="card-header">Immagine profilo</div>
                        <div class="card-body text-center">
                            <!-- Profile picture image-->
                            <img class="img-account-profile rounded-circle mb-2"
                                 src="{{asset('assets/img/avatar/profile-'.rand(1, 6).'.webp')}}"
                                 alt="Immagine di profilo"/>
                        </div>
                        <div class="card-footer text-center">
                            <!-- Profile picture help block-->
                            <div class="small font-italic text-muted mb-4">L'immagine di profilo è casuale</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <!-- Account details card-->
                    <div class="card mb-4">
                        <div class="card-header">Dettagli account</div>
                        <div class="card-body">
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (email)-->
                                <div class="col-md-12">
                                    <label class="small mb-1" for="inputEmail">Email</label>
                                    <input class="form-control" name="email" id="inputEmail" type="text" value=""
                                           required/>
                                </div>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-3">
                                <!-- Form Group (first name)-->
                                <div class="col-md-6 mb-3">
                                    <label class="small mb-1" for="inputFirstName">Nome</label>
                                    <input class="form-control" name="name" id="inputFirstName" type="text" value=""
                                           required/>
                                </div>
                                <!-- Form Group (last name)-->
                                <div class="col-md-6 mb-3">
                                    <label class="small mb-1" for="inputLastName">Cognome</label>
                                    <input class="form-control" name="surname" id="inputLastName" type="text" value=""
                                           required/>
                                </div>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-3">
                                <!-- Form Group (roles)-->
                                <div class="col-md-6 mb-3">
                                    <label class="small mb-1" for="inputRoles">Ruolo</label>
                                    <input class="form-control text-capitalize" id="inputRoles" disabled
                                           placeholder="{{$page}}">
                                    <input type="hidden" value="{{$page}}" name="role">
                                </div>
                                <!-- Form Group (team)-->
                                <div class="col-md-6 mb-3">
                                    <label class="small mb-1" for="inputTeam">Team</label>
                                    <select name="team" class="form-select text-capitalize" id="inputTeam" required>
                                        <option value=""></option>
                                        <?php
                                        $opt_arr = ['Mamateam 2.0', 'Cantera'];
                                        foreach ($opt_arr as $opt) {
                                            echo '<option class="text-capitalize" value="' . $opt . '">' . $opt . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- Submit button-->
                            <button class="btn btn-primary" type="submit">Aggiungi utente</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
    <!-- Bootstrap Toggle-->
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
@endsection
