@php use Carbon\Carbon; @endphp
@php use Illuminate\Support\Facades\DB; @endphp
@extends('../../ar/layouts/layout')

@section('title', 'AR | Tavoli')
@section('link')
    <link href="{{asset('assets/bootstrap/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/bootstrap/css/responsive.bootstrap5.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/bootstrap/css/buttons.bootstrap5.min.css')}}" rel="stylesheet">
@endsection
@section('content')
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="list"></i></div>
                            Tavoli
                        </h1>
                        Lista tavoli &middot; {{$tables->count()}} totali
                    </div>
                    <div class="col-auto align-items-right mb-3">
                        <a class="btn btn-sm btn-light text-primary" data-bs-toggle="modal"
                           data-bs-target="#tableModal">
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
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-3">
                                <strong>EVENTO</strong>: {{$event->titolo}}
                            </div>
                            <div class="col-sm-3">
                                <strong>DISCOTECA</strong>: {{$event->discoteca}}
                            </div>
                            <div class="col-sm-2">
                                <strong>DATA</strong>: {{Carbon::parse($event->date)->format('d/m/Y')}}
                            </div>
                            <div class="col-sm-2">
                                <strong>PAGATO</strong>: {!! (!$event->pagato) ? '<i class="fas fa-times text-danger"></i>' : '<i class="fas fa-check text-success"></i>' !!}
                            </div>
                            <div class="col-sm-2" id="exportButtons"></div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(count($tables))
                            <div class="datatable">
                                <table class="table table-bordered table-hover text-center display rounded"
                                       id="example">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nome</th>
                                        <th>Persone</th>
                                        <th>Età media</th>
                                        <th>Dettagli</th>
                                        <th>Fatto da</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php ($c = 1)
                                    @foreach($tables as $table)
                                        <tr>
                                            <td>{{$c++}}</td>
                                            <td class="text-uppercase">{{$table->nome}}</td>
                                            <td>{{$table->persone}} persone</td>
                                            <td>{{($table->etaMedia == NULL || $table->etaMedia == "/" || $table->etaMedia == " ") ? "/" : $table->etaMedia." anni"}}</td>
                                            <td>{{($table->dettagli == NULL || $table->dettagli == "/" || $table->dettagli == " ") ? "/" : $table->dettagli}}</td>
                                            <td>{{$table->fattoDa}}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a class="btn btn-success p-3 shadow" data-bs-toggle="modal"
                                                       data-bs-target="#tableUpdateModal{{$table->id}}"><i
                                                            class="fas fa-edit"></i></a>
                                                    <a type="button" href="#" class="btn btn-danger"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#confirm-delete-{{$table->id}}"><i
                                                            class="fas fa-trash-alt"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Update Modal -->
                                        <div class="modal fade" id="tableUpdateModal{{$table->id}}" tabindex="-1"
                                             data-bs-backdrop="static" aria-labelledby="tableUpdateModalLabel"
                                             aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Modifica
                                                            tavolo</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <form class="form"
                                                          action="{{route('edit-tavolo', [$table->id])}}"
                                                          method="post"
                                                          enctype="multipart/form-data">
                                                        <div class="modal-body">

                                                            @csrf
                                                            <input type="hidden" name="event_id" value="{{$event->id}}">
                                                            <div class="row mb-3">
                                                                <div class="col-md-6">
                                                                    <label for="inputNome"
                                                                           class="small mb-1">Nome</label>
                                                                    <input type="text" class="form-control"
                                                                           id="inputNome"
                                                                           name="nome"
                                                                           placeholder="MARIO ROSSI"
                                                                           value="{{$table->nome}}">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="inputPersone"
                                                                           class="small mb-1">Persone</label>
                                                                    <input type="number" class="form-control"
                                                                           id="inputPersone" name="persone"
                                                                           placeholder="15" value="{{$table->persone}}">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-6">
                                                                    <label for="inputEtaMedia" class="small mb-1">Età
                                                                        media</label>
                                                                    <input type="text" class="form-control"
                                                                           id="inputEtaMedia" name="etaMedia"
                                                                           placeholder="18/19"
                                                                           value="{{$table->etaMedia}}">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="inputFattoDa" class="small mb-1">Fatto
                                                                        da</label>
                                                                    <input class="form-control" list="browser"
                                                                           name="fattoDa" id="inputFattoDa"
                                                                           value="{{$table->fattoDa}}">
                                                                    <datalist id="browser">
                                                                        <option value=""></option>
                                                                        @php($opt_arr = DB::table('users')->get())
                                                                        @foreach ($opt_arr as $opt)
                                                                            @php($sel = '')
                                                                            @if ($opt->username == $table->fattoDa)
                                                                                @php($sel = 'selected')
                                                                            @endif
                                                                            <option
                                                                                value="{{$opt->username}}" {{$sel}}></option>
                                                                        @endforeach
                                                                    </datalist>
                                                                </div>
                                                            </div>
                                                            <!-- Form Group (dettagli)-->
                                                            <div class="row mb-3">
                                                                <div class="col-md-12">
                                                                    <label for="inputDettagli"
                                                                           class="small mb-1">Dettagli</label>
                                                                    <textarea id="inputDettagli" class="form-control"
                                                                              name="dettagli"
                                                                              rows="4">{{$table->dettagli}}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Salva</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Annulla
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Delete Confirmation Modal -->
                                        <div class="modal fade" id="confirm-delete-{{$table->id}}" tabindex="-1"
                                             role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Conferma</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <form action="" method="POST">
                                                        <div class="modal-body">
                                                            <p>Sei sicuro di voler eliminare il tavolo {{$table->nome}}
                                                                ?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="{{ route('delete-tavolo', $table->id) }}"
                                                               class="btn btn-primary pull-left">Si </a>
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">No
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    </tbody>
                                </table>
                                <!-- //Table -->
                            </div>
                        @else
                            <div class="card-text text-center">Nessuna tavolo per questo evento</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endsection
        @section('scripts')
            <!-- Insert Modal -->
            <div class="modal fade" id="tableModal" tabindex="-1" data-backdrop="static"
                 aria-labelledby="tableModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Inserisci tavolo</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <form class="form" action="{{route('create-tavolo')}}" method="post"
                              enctype="multipart/form-data">
                            <div class="modal-body">
                                <input type="hidden" name="event_id" value="{{$event->id}}">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="inputNome" class="small mb-1">Nome</label>
                                        <input type="text" class="form-control"
                                               id="inputNome"
                                               name="nome"
                                               placeholder="MARIO ROSSI"
                                               value="">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputPersone" class="small mb-1">Persone</label>
                                        <input type="number" class="form-control"
                                               id="inputPersone" name="persone"
                                               placeholder="15" value="">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="inputEtaMedia" class="small mb-1">Età media</label>
                                        <input type="text" class="form-control"
                                               id="inputEtaMedia" name="etaMedia"
                                               placeholder="18/19"
                                               value="">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputFattoDa" class="small mb-1">Fatto da</label>
                                        <input class="form-control" list="browser"
                                               name="fattoDa" id="inputFattoDa"
                                               value="">
                                        <datalist id="browser">
                                            <option value=""></option>
                                            @php($opt_arr = DB::table('users')->get())
                                            @foreach ($opt_arr as $opt)
                                                <option
                                                    value="{{$opt->username}}"></option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>
                                <!-- Form Group (dettagli)-->
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="inputDettagli" class="small mb-1">Dettagli</label>
                                        <textarea id="inputDettagli" class="form-control"
                                                  name="dettagli"
                                                  rows="4"></textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Salva</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Page level plugins -->
            <script type="text/javascript" src="{{asset('assets/bootstrap/js/jquery.dataTables.min.js')}}"></script>
            <script type="text/javascript" src="{{asset('assets/bootstrap/js/dataTables.bootstrap5.min.js')}}"></script>
            <script type="text/javascript" src="{{asset('assets/bootstrap/js/dataTables.buttons.min.js')}}"></script>
            <script type="text/javascript" src="{{asset('assets/bootstrap/js/buttons.colVis.min.js')}}"></script>
            <script type="text/javascript" src="{{asset('assets/bootstrap/js/buttons.html5.min.js')}}"></script>
            <script type="text/javascript" src="{{asset('assets/bootstrap/js/buttons.print.min.js')}}"></script>
            <script type="text/javascript" src="{{asset('assets/bootstrap/js/buttons.bootstrap5.min.js')}}"></script>
            <script type="text/javascript" src="{{asset('assets/bootstrap/js/dataTables.responsive.min.js')}}"></script>
            <script type="text/javascript" src="{{asset('assets/bootstrap/js/pdfmake.min.js')}}"></script>
            <script type="text/javascript" src="{{asset('assets/bootstrap/js/jszip.min.js')}}"></script>
            <script type="text/javascript" src="{{asset('assets/bootstrap/js/vfs_fonts.js')}}"></script>
            <script type="text/javascript">
                function toDataURL(url, callback) {
                    let xhr = new XMLHttpRequest();
                    xhr.onload = function () {
                        let reader = new FileReader();
                        reader.onloadend = function () {
                            callback(reader.result);
                        }
                        reader.readAsDataURL(xhr.response);
                    };
                    xhr.open('GET', url);
                    xhr.responseType = 'blob';
                    xhr.send();
                }

                let dataImage = "";
                toDataURL('{{asset('assets/img/logo.png')}}', function (dataUrl) {
                    dataImage = dataUrl;
                });

                $(document).ready(function () {
                    $('#example').DataTable({
                        dom: "<'row mb-3'<'col-sm-4'l><'col-sm-8 text-end'<'d-flex justify-content-end'fB>>>t<'d-flex align-items-center'<'me-auto'i><'mb-0'p>>",
                        responsive: true,
                        ordering: true,
                        paging: true,
                        info: true,
                        searching: true,
                        columns: [
                            {orderable: false},
                            null,
                            {orderable: false},
                            {orderable: false},
                            {orderable: false},
                            {orderable: false},
                            {orderable: false}
                        ],
                        buttons: [
                            {
                                extend: 'pdfHtml5',
                                className: 'btn bt-light mx-2',
                                orientation: 'landscape',
                                pageSize: 'A4',
                                exportOptions: {
                                    columns: [0, 1, 2, 5, 6]
                                },
                                customize: function (doc) {
                                    //Remove the title created by datatTables
                                    doc.content.splice(0, 1);
                                    // Logo converted to base64
                                    let logo = dataImage;
                                    // A documentation reference can be found at
                                    // https://github.com/bpampuch/pdfmake#getting-started
                                    // Set page margins [left,top,right,bottom] or [horizontal,vertical]
                                    // or one number for equal spread
                                    // It's important to create enough space at the top for a header !!!
                                    doc.pageMargins = [20, 60];
                                    // Set the font size fot the entire document
                                    doc.defaultStyle.fontSize = 10;
                                    // Create a header object with 3 columns
                                    // Left side: Logo
                                    // Middle: brandname
                                    // Right side: A document title
                                    doc['header'] = (function () {
                                        return {
                                            columns: [
                                                {
                                                    image: logo,
                                                    width: 24
                                                },
                                                {
                                                    alignment: 'center',
                                                    italics: true,
                                                    text: 'Tavoli evento: ' + "@php(print_r($event->titolo))",
                                                    fontSize: 18
                                                }
                                            ],
                                            margin: 20
                                        }
                                    });
                                    doc.defaultStyle.noWrap = true;
                                    doc.styles.tableHeader.fontSize = 12;
                                    doc.styles.tableHeader.alignment = 'center';
                                    doc.styles.tableBodyEven.alignment = 'center';
                                    doc.styles.tableBodyOdd.alignment = 'center';
                                    doc.content[0].table.widths = [30, 200, 'auto', 300, 'auto'];
                                },
                                text: '<i class="fas fa-file-export"></i>&nbsp;Esporta pdf',
                                download: 'open'
                            }
                        ]
                    });
                    $('.buttons-pdf').detach().appendTo('#exportButtons');
                });
            </script>
@endsection
