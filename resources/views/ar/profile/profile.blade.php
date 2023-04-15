@php use Illuminate\Support\Facades\Auth; @endphp
@php use Carbon\Carbon; @endphp
@extends('ar.layouts.layout')

@section('title', 'AR | Profilo')
@section('link')
    <link href="{{asset('assets/bootstrap/css/bootstrap-datepicker3.css')}}" rel="stylesheet">
    <link href="https://unpkg.com/dropzone/dist/dropzone.css" rel="stylesheet"/>
    <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>
@endsection
@section('content')
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            Impostazioni account - Profilo
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
            <a class="nav-link active ms-0" href="{{route('profile')}}">Profilo</a>
            <a class="nav-link" href="{{route('security')}}">Sicurezza</a>
        </nav>
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
                                     src="{{asset('assets/img/avatar').'/'.Auth::user()->avatar}}" id="uploaded_image"
                                     alt="Immagine profilo">
                                <div class="overlay overlay-white">
                                    <div class="text">Cambia immagine di profilo</div>
                                </div>
                                <input type="file" name="image" class="image" id="upload_image" style="display:none"
                                       accept="image/*"/>
                            </label>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteAvatar"
                            @php($avatar = Auth::user()->avatar)
                        @switch($avatar)
                            @case('profile-1.webp')
                                {{'disabled'}}
                                    @break
                                @case('profile-2.webp')
                                {{'disabled'}}
                                    @break
                                @case('profile-3.webp')
                                {{'disabled'}}
                                    @break
                                @case('profile-4.webp')
                                {{'disabled'}}
                                    @break
                                @case('profile-5.webp')
                                {{'disabled'}}
                                    @break
                                @case('profile-6.webp')
                                {{'disabled'}}
                                    @break
                            @endswitch
                        >
                            Elimina
                        </button>
                    </div>
                </div>
                <!-- Account social card-->
                <div class="card mb-4">
                    <div class="card-header">Link social</div>
                    <div class="card-body">
                        <form class="form" method="post" action="{{route('profile_update_social')}}"
                              enctype="multipart/form-data">
                            @csrf
                            <!-- Form (username)-->
                            <label class="small mb-1" for="inputFacebook">Account Facebook</label>
                            <div class="input-group mb-3">
                                @if(Auth::user()->account_facebook != null)
                                    <a
                                        class="btn btn-outline-primary" type="button"
                                        href="{{Auth::user()->account_facebook}}"
                                        target="_blank">Accedi</a>
                                @endif
                                <input class="form-control" id="inputFacebook" type="text"
                                       value="{{Auth::user()->account_facebook}}" name="account_facebook"
                                       placeholder="https://www.facebook.com/username/">
                            </div>
                            <!-- Form (username)-->
                            <label class="small mb-1" for="inputInstagram">Account Instagram</label>
                            <div class="input-group mb-3">
                                @if(Auth::user()->account_instagram != null)
                                    <a
                                        class="btn btn-outline-danger" type="button"
                                        href="{{Auth::user()->account_instagram}}"
                                        target="_blank">Accedi</a>
                                @endif
                                <input class="form-control" id="inputInstagram" type="text"
                                       value="{{Auth::user()->account_instagram}}" name="account_instagram"
                                       placeholder="https://www.instagram.com/username/?hl=it">
                            </div>
                            <!-- Save changes button-->
                            <button class="btn btn-primary" type="submit"><i class="far fa-save"></i>&nbsp;Salva
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <!-- Account details card-->
                <div class="card mb-4">
                    <div class="card-header">Dettagli account</div>
                    <div class="card-body">
                        <form class="form" method="post" action="{{route('profile_update')}}"
                              enctype="multipart/form-data">
                            @csrf
                            <!-- Form (username)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="inputUsername">Username</label>
                                <input class="form-control" id="inputUsername" type="text"
                                       value="{{Auth::user()->username}}" name="username" placeholder=""></div>
                            <!-- Form Row-->
                            <div class="row gx-3">
                                <!-- Form Group (nome)-->
                                <div class="col-md-6 mb-3">
                                    <label class="small mb-1" for="inputFirstName">Nome</label>
                                    <input class="form-control" id="inputFirstName" type="text"
                                           value="{{Auth::user()->name}}" name="name" placeholder=""></div>
                                <!-- Form Group (cognome)-->
                                <div class="col-md-6 mb-3">
                                    <label class="small mb-1" for="inputLastName">Cognome</label>
                                    <input class="form-control" id="inputLastName" type="text"
                                           value="{{Auth::user()->surname}}" name="surname" placeholder=""></div>
                            </div>
                            <!-- Form Row-->
                            <div class="mb-3">
                                <!-- Form Group (email)-->
                                <label class="small mb-1" for="inputEmail">Email</label>
                                <input class="form-control" id="inputEmail" type="email" value="{{Auth::user()->email}}"
                                       name="email" placeholder="">
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-3">
                                <!-- Form Group (birthday)-->
                                <div class="col-md-6 mb-3">
                                    <label class="small mb-1" for="date">Data di nascita</label>
                                    <input class="form-control datepicker" id="date" type="text"
                                           value="{{Carbon::parse(Auth::user()->birthday)->format('d/m/Y')}}"
                                           name="birthday"></div>
                                <!-- Form Group (phone)-->
                                <div class="col-md-6 mb-3">
                                    <label class="small mb-1" for="inputPhone">Cellulare</label>
                                    <input class="form-control" id="inputPhone" type="text"
                                           value="{{Auth::user()->phone}}" name="phone" placeholder="">
                                </div>
                            </div>

                            <!-- Form Row-->
                            <div class="row gx-3">
                                <!-- Form Group (address)-->
                                <div class="col-md-4 mb-3">
                                    <label class="small mb-1" for="inputAddress">Indirizzo</label>
                                    <input class="form-control" id="inputAddress" type="text"
                                           value="{{Auth::user()->address}}" name="address" placeholder="">
                                </div>
                                <!-- Form Group (ruolo)-->
                                <div class="col-md-4 mb-3">
                                    <label class="small mb-1" for="inputRuolo">Ruolo</label>
                                    <input class="form-control text-capitalize" id="inputRuolo" type="text"
                                           value="{{Auth::user()->getRoleNames()->get(0)}}" disabled placeholder="">
                                </div>
                                <!-- Form Group (Team)-->
                                <div class="col-md-4 mb-3">
                                    <label class="small mb-1" for="inputTeam">Team</label>
                                    <input class="form-control" id="inputTeam" type="text"
                                           value="{{Auth::user()->team}}" disabled placeholder="">
                                </div>
                            </div>
                            <!-- Save changes button-->
                            <button class="btn btn-primary" type="submit"><i class="far fa-save"></i>&nbsp;Salva
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Profile Image Crop Confirmation-->
    <div class="modal fade text-center" id="profileAvatar" data-bs-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Immagine del profilo</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-md-8">
                                <img class="img-fluid" src="" id="sample_image" alt="sample img to crop"/>
                            </div>
                            <div class="col-md-4">
                                <div class="preview"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="crop" class="btn btn-primary"><i class="fas fa-crop-alt"></i>&nbsp;Taglia
                    </button>
                    <button type="button" id="annulla" class="btn btn-secondary" data-bs-dismiss="modal">Annulla
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Avatar Delete -->
    <div class="modal fade" id="deleteAvatar" data-bs-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Elimina avatar</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Vuoi eliminare l'avatar?</p>
                </div>
                <div class="modal-footer">
                    <form action="{{route('profile_deleteAvatar')}}" method="get" enctype="multipart/form-data">
                        <button type="submit" class="btn btn-primary" name="avatar-delete">Si</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{asset('assets/bootstrap/js/bootstrap-datepicker.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/bootstrap/js/bootstrap-datepicker.it.min.js')}}"></script>
    <script type="text/javascript" src="https://unpkg.com/dropzone"></script>
    <script type="text/javascript" src="https://unpkg.com/cropperjs"></script>
    <script type="text/javascript">
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy'
        });

        $(document).ready(function () {
            let modal = $('#profileAvatar');
            let image = document.getElementById('sample_image');
            let cropper;
            $('#upload_image').change(function (event) {
                let files = event.target.files;

                let done = function (url) {
                    image.src = url;
                    modal.modal('show');
                };

                if (files && files.length > 0) {
                    let reader = new FileReader();
                    reader.onload = function (event) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(files[0]);
                }
            });
            modal.on('shown.bs.modal', function () {
                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 3,
                    preview: '.preview'
                });
            }).on('hidden.bs.modal', function () {
                cropper.destroy();
                cropper = null;
            });

            $('#crop').click(function () {
                $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Caricamento...</span>');
                $(this).attr('disabled', 'true');
                $('#annulla').attr('disabled', 'true');
                canvas = cropper.getCroppedCanvas({
                    width: 400,
                    height: 400
                });

                canvas.toBlob(function (blob) {
                    let reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function () {
                        const base64data = reader.result;
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '{{route('profile_uploadAvatar')}}',
                            type: 'post',
                            data: {
                                'image': base64data
                            },
                            success: (data) => {
                                window.location.href = "{{route('profile')}}";
                            },
                            error: function (data) {
                                window.location.href = "{{route('profile')}}";
                            }
                        });
                    };
                });
            });
        });
    </script>
@endsection
