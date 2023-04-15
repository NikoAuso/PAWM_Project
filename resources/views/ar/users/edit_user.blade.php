@extends('../../ar/layouts/layout')

@section('title', 'AR | Utenti')
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
                            Modifica utente
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
    <form action="{{route('edit-user', ['id' => $data->id, 'page' => $page])}}" method="POST"
          id="customer_form" enctype="multipart/form-data">
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
                                 src="{{asset('assets/img/avatar/').'/'.$data->avatar}}"
                                 alt="Immagine di profilo"/>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <!-- Account details card-->
                    <div class="card mb-4">
                        <div class="card-header">Dettagli account</div>
                        <div class="card-body">
                            <!-- Form Row-->
                            <div class="row gx-3">
                                <!-- Form Group (username)-->
                                <div class="col-md-6 mb-3">
                                    <label class="small mb-1" for="inputUserName">Username</label>
                                    <input class="form-control" name="username" id="inputUserName" type="text"
                                           value="{{$data->username}}" required/>
                                </div>
                                <!-- Form Group (email)-->
                                <div class="col-md-6 mb-3">
                                    <label class="small mb-1" for="inputEmail">Email</label>
                                    <input class="form-control" name="email" id="inputEmail" type="text"
                                           value="{{$data->email}}" required/>
                                </div>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-3">
                                <!-- Form Group (first name)-->
                                <div class="col-md-6 mb-3">
                                    <label class="small mb-1" for="inputFirstName">Nome</label>
                                    <input class="form-control" name="name" id="inputFirstName" type="text"
                                           value="{{$data->name}}" required/>
                                </div>
                                <!-- Form Group (last name)-->
                                <div class="col-md-6 mb-3">
                                    <label class="small mb-1" for="inputLastName">Cognome</label>
                                    <input class="form-control" name="surname" id="inputLastName" type="text"
                                           value="{{$data->surname}}" required/>
                                </div>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-3">
                                <!-- Form Group (roles)-->
                                <div class="col-md-4 mb-3">
                                    @can('super-admin')
                                        <label class="small mb-1" for="inputRoles">Ruolo</label>
                                        <select name="role" class="form-select text-capitalize" id="inputRoles"
                                                required>
                                            <option value=""></option>
                                                <?php
                                                $opt_arr = \Spatie\Permission\Models\Role::all();
                                                foreach ($opt_arr as $opt) {
                                                    if ($opt->name == $data->getRoleNames()->get(0)) {
                                                        $sel = 'selected';
                                                    } else {
                                                        $sel = '';
                                                    }
                                                    echo '<option class="text-capitalize" value="' . $opt . '"' . $sel . '>' . $opt->name . '</option>';
                                                }
                                                ?>
                                        </select>
                                    @else
                                        <label class="small mb-1" for="inputRoles">Ruolo</label>
                                        <input class="form-control text-capitalize" id="inputRoles" readonly
                                               placeholder="{{$data->getRoleNames()->get(0)}}" name="role"
                                               value="{{$data->getRoleNames()->get(0)}}">
                                    @endcan
                                </div>
                                <!-- Form Group (team)-->
                                <div class="col-md-4 mb-3">
                                    <label class="small mb-1" for="inputTeam">Team</label>
                                    <select name="team" class="form-select text-capitalize" id="inputTeam" required>
                                        <option value=""></option>
                                            <?php
                                            $opt_arr = ['Mamateam 2.0', 'Cantera'];
                                            foreach ($opt_arr as $opt) {
                                                if ($opt == $data->team) {
                                                    $sel = 'selected';
                                                } else {
                                                    $sel = '';
                                                }
                                                echo '<option class="text-capitalize" value="' . $opt . '"' . $sel . '>' . $opt . '</option>';
                                            }
                                            ?>
                                    </select>
                                </div>
                                <!-- Form Check (evento attivo)-->
                                <div class="col-md-4 mb-3">
                                    <label class="small mb-1" for="inputActive">Account attivo</label>
                                    <div class="pl-0">
                                        <input class="form-check-input"
                                               id="inputActive"
                                               type="checkbox"
                                               name="active"
                                               value="1"
                                               data-toggle="toggle"
                                               data-height="38"
                                               data-on="Attivo"
                                               data-off="Non attivo"
                                               data-onstyle="success"
                                               data-offstyle="danger"
                                        @if($data->active == 1)
                                            {{'checked'}}
                                            @endif
                                        />
                                    </div>
                                </div>
                            </div>
                            <!-- Submit button-->
                            <button class="btn btn-primary gx-3" type="submit">
                                <i class="fas fa-save"></i>&nbsp;Salva
                            </button>
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
