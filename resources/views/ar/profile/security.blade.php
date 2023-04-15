@extends('ar.layouts.layout')

@section('title', 'AR | Profilo')
@section('content')
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            Impostazioni account - Sicurezza
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    @include('ar.layouts.message')
    <!-- Main page content-->
    <div class="container-xl px-4 mt-4">
        <!-- Account page navigation-->
        <nav class="nav nav-borders">
            <a class="nav-link" href="{{route('profile')}}">Profilo</a>
            <a class="nav-link active ms-0" href="{{route('security')}}">Sicurezza</a>
        </nav>
        <hr class="mt-0 mb-4"/>
        <!-- Account page navigation-->
        <div class="row">
            <div class="col-lg-12">
                <!-- Profile picture card-->
                <div class="card mb-4">
                    <div class="card-header">Cambia password</div>
                    <div class="card-body">
                        <form class="form" method="post" action="{{route('security_change')}}"
                              enctype="multipart/form-data" id="formPasswordChange">
                        @csrf
                        <!-- Form Group (current password)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="currentPassword">Password attuale</label>
                                <input class="form-control" name="old_password" id="currentPassword" type="password"
                                       placeholder="Inserisci la password attuale" required/>
                            </div>
                            <!-- Form Group (new password)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="newPassword">Nuova Password</label>
                                <input class="form-control" name="new_password" id="newPassword" type="password"
                                       placeholder="Inserisci la nuova password" required/>
                            </div>
                            <!-- Form Group (confirm password)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="confirmPassword">Conferma Password</label>
                                <input class="form-control" name="confirm_password" id="confirmPassword" type="password"
                                       placeholder="Conferma la nuova password" required/>
                            </div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#deleteAvatar"><i
                                        class="far fa-save"></i>&nbsp;Salva
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Password change -->
    <div class="modal fade" id="deleteAvatar" data-bs-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Vuoi cambiare password?</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Al termine dell'operazione <strong>verrai reindirizzato</strong> alla pagina del login, dalla quale dovrai rieseguire l'accesso.</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="submit">Cambia</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $('#submit').click(function(){
            $('#formPasswordChange').submit();
        });
    </script>
@endsection
