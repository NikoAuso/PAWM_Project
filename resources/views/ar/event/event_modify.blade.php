@php use Carbon\Carbon; @endphp
@extends('../../ar/layouts/layout')

@section('title', 'AR | Eventi')
@section('link')
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
          rel="stylesheet">
    <link href="{{asset('assets/bootstrap/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/summertime-editor/summernote-lite.min.css')}}" rel="stylesheet">
    <style>
        .fade:not(.show) {
            opacity: 1;
        }
    </style>
@endsection
@section('content')
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="file-text"></i></div>
                            Modifica evento
                        </h1>
                    </div>
                    <div class="col-12 col-lg-auto mb-3">
                        @if(!$data->isJolly)
                            <a class="btn btn-warning mb-1" href="{{route('tavoli.event', $data->id)}}">
                                <i class="fas fa-glass-martini-alt"></i>
                            </a>
                            <a class="btn btn-success mb-1" href="{{route('liste.event', $data->id)}}">
                                <i class="fa-solid fa-list-check"></i>
                            </a>
                        @endif
                        @if($data->active)
                            <a class="btn btn-secondary mb-1" href="{{route('singleEvent', $data->id)}}"
                               target="_blank">
                                <i class="fas fa-eye"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </header>
    @include('ar.layouts.message')
    <!-- Main page content-->
    <form action="{{route('edit-event', ['id' => $data->id])}}" method="post"
          id="customer_form" enctype="multipart/form-data">
        @csrf
        <div class="container-xl px-4 mt-4">
            <div class="row">
                <!-- Copertina evento-->
                <div class="col-lg-4">
                    <!-- Event picture card-->
                    <div class="card mb-4 mb-xl-0">
                        <div class="card-header">Copertina dell'evento</div>
                        <div class="card-body text-center">
                            <!-- Event picture image-->
                            <img class="img-fluid rounded" style="padding: 15px; display:initial"
                                 src="{{asset('assets/img/events').'/'.$data->image}}"
                                 alt="Immagine di copertina dell'evento" id="output">
                            <!-- Profile picture help block-->
                            <div class="small font-italic text-muted mb-0">Carica la copertina Instagram dell'evento
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="customFile"></label>
                                <input type="file" accept="image/*" class="form-control" id="customFile"
                                       onchange="loadFile(event)" name="image">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Dettagli evento-->
                <div class="col-lg-8">
                    <!-- Event details card-->
                    <div class="card mb-4">
                        <div class="card-header">Dettagli evento</div>
                        <div class="card-body">
                            <!-- Form Group (titolo)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="inputTitolo">Titolo</label>
                                <input class="form-control" id="inputTitolo" type="text" value="{{$data->titolo}}"
                                       name="titolo" placeholder="">
                            </div>
                            <!-- Form Row (extra)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="inputTitolo2">(dettagli titolo extra)</label>
                                <input class="form-control" id="inputTitolo2" type="text"
                                       value="{{$data->extra}}" name="extra" placeholder="">
                            </div>
                            <!-- Form Row (discoteca - data)-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (discoteca)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputDisco">Discoteca</label>
                                    <select name="discoteca" class="form-control selectpicker" id="inputDisco">
                                        <option value=""></option>
                                        <?php
                                        $opt_arr = array("MAMAMIA", "MIAMI", "NOIR", "DIRETTA INSTAGRAM");
                                        foreach ($opt_arr as $opt) {
                                            if ($opt == $data->discoteca) {
                                                $sel = 'selected';
                                            } else {
                                                $sel = '';
                                            }
                                            echo '<option value="' . $opt . '"' . $sel . '>' . $opt . '</option>';
                                        } ?>
                                    </select>
                                </div>
                                <!-- Form Row(data)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="datetimepicker1">Data e ora</label>
                                    <input type="text" class="form-control datetimepicker-input"
                                           id="datetimepicker1" name="date"
                                           value="@if($data->date != null){{Carbon::parse($data->date)->formatLocalized('%e/%m/%Y %HH:%MM')}}@endif"/>
                                </div>
                            </div>
                            <!-- Form Row (descrizione - active - jolly - pagato)-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (descrizione)-->
                                <div class="col-md-9">
                                    <label class="small mb-1" for="summernote">Descrizione</label>
                                    <textarea class="form-control" id="summernote" name="descrizione">
                                                {!! $data->descrizione !!}
                                            </textarea>
                                </div>
                                <div class="col-md-3">
                                    <!-- Form Check (evento attivo)-->
                                    <div class="mb-3">
                                        <div class="col-md-12">
                                            <label class="small mb-1" for="inputActive">Evento attivo</label>
                                            <div class="pl-0">
                                                <input class="form-check-input"
                                                       id="inputActive"
                                                       type="checkbox"
                                                       name="active"
                                                       value="1"
                                                       data-toggle="toggle"
                                                       data-height="38"
                                                       data-on="Si"
                                                       data-off="No"
                                                       data-onstyle="success"
                                                       data-offstyle="danger"
                                                @if($data->active == 1)
                                                    {{'checked'}}
                                                        @endif
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Form Check (jolly)-->
                                    <div class="mb-3">
                                        <div class="col-md-12">
                                            <label class="small mb-1" for="inputJolly">Evento tipo</label>
                                            <div class="pl-0">
                                                <input class="form-check-input"
                                                       id="inputJolly"
                                                       type="checkbox"
                                                       name="isJolly"
                                                       value="1"
                                                       data-toggle="toggle"
                                                       data-height="38"
                                                       data-on="Jolly"
                                                       data-off="Normale"
                                                       data-onstyle="warning"
                                                @if($data->isJolly == 1)
                                                    {{'checked'}}
                                                        @endif
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Form Check (evento pagato)-->
                                    <div class="mb-3">
                                        <div class="col-md-12">
                                            <label class="small mb-1" for="inputPagato">Tavoli pagati</label>
                                            <div class="pl-0">
                                                <input class="form-check-input"
                                                       id="inputPagato"
                                                       type="checkbox"
                                                       name="pagato"
                                                       value="1"
                                                       data-toggle="toggle"
                                                       data-height="38"
                                                       data-on="Si"
                                                       data-off="No"
                                                       data-onstyle="success"
                                                       data-offstyle="danger"
                                                @if($data->pagato == 1)
                                                    {{'checked'}}
                                                        @endif
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Save changes button-->
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-save"></i>&nbsp;Salva
                            </button>
                            <a href="#" class="btn btn-danger delete_btn" data-bs-toggle="modal"
                               data-bs-target="#confirm-delete">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
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
                <form action="" method="POST">
                    <div class="modal-body">
                        <p>Sei sicuro di voler eliminare l'evento "<strong>{{$data->titolo}}</strong>"?</p>
                    </div>
                    <div class="modal-footer">
                        <a href="{{route('delete-event', [$data->id])}}" class="btn btn-primary pull-left">Si</a>
                        <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">No
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap Toggle-->
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <!-- Bootstrap core Datetimepicker (event countdown)-->
    <script type="text/javascript" src="{{asset('assets/bootstrap/js/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/bootstrap/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker1').datetimepicker({
                icons: {
                    time: 'far fa-clock',
                    date: 'far fa-calendar-alt',
                    up: 'fas fa-arrow-up',
                    down: 'fas fa-arrow-down',
                    previous: 'fas fa-arrow-left',
                    next: 'fas fa-arrow-right',
                    today: 'fas fa-crosshairs',
                    clear: 'fas fa-trash',
                    close: 'fas fa-times'
                },
                locale: 'it'
            });
        });
    </script>

    <!-- Custom scripts for event editor-->
    <script src="{{asset('assets/summertime-editor/summernote-lite.min.js')}}"></script>
    <script src="{{asset('assets/summertime-editor/lang/summernote-it-IT.js')}}"></script>
    <script type="text/javascript">
        $('#summernote').summernote({
            lang: 'it-IT',
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['para', ['ul']],
                ['height', ['none']],
                ['insert', ['link']],
                ['view', ['undo', 'redo', 'codeview']],
            ],
            style: 'text-white',
            minHeight: '160px',
            placeholder: 'Scrivi qui la descrizione dell\'evento...',
            dialogsFade: true,
            spellCheck: true,
            disableGrammar: true,
            disableDragAndDrop: true,
            callbacks: {
                onPaste: function (e) {
                    const bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                    e.preventDefault();
                    document.execCommand('insertText', false, bufferText);
                }
            }
        });
        $('#closeModal').on('click', function () {
            $('#linkModal').modal('hide');
        })
        const loadFile = function (event) {
            const output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function () {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>
@endsection
