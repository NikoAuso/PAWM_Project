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
                </div>
            </div>
        </div>
    </header>
    @include('ar.layouts.message')
    <!-- Main page content-->
    <div class="container-xl px-4 mt-5">
        <div class="row">
            <div class="col-xl-12 col-sm-12 mb-12">
                @role('admin')
                <!-- Form ricerca tavoli -->
                <form class="form mb-4 mt-2" action="{{route('tavoli.search')}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="input-group mb-3">
                            <label for="inputUsername"></label>
                            <input class="form-control rounded-start" list="browser" name="username" id="inputUsername"
                                   placeholder="Selezione il pr...">
                            <datalist id="browser">
                                <option value=""></option>
                                <?php
                                $opt_arr = \Illuminate\Support\Facades\DB::table('users')->get();
                                foreach ($opt_arr as $opt) {
                                    echo '<option value="' . $opt->id . '">' . $opt->username . ' - ' . $opt->name . ' ' . $opt->surname . '</option>';
                                } ?>
                            </datalist>
                            <label for="inputEvento"></label>
                            <input class="form-control" list="browser2" name="evento" id="inputEvento"
                                   placeholder="Seleziona l'evento...">
                            <datalist id="browser2">
                                <option value=""></option>
                                <?php
                                $opt_arr = \Illuminate\Support\Facades\DB::table('events')->orderBy('date', 'desc')->get();
                                foreach ($opt_arr as $opt) {
                                    echo '<option value="' . $opt->id . '">' . $opt->titolo . ' - ' . $opt->discoteca . ' ' . \Carbon\Carbon::parse($opt->date)->format('d/m/Y') . '</option>';
                                } ?>
                            </datalist>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>&nbsp;Cerca
                            </button>
                            <a type="button" class="btn btn-dark" href="{{route('tavoli')}}">
                                Cancella filtro
                            </a>
                        </div>
                    </div>
                </form>
                @endrole
                <!-- Tabella tavoli con bottoni -->
                <div class="card card-waves mb-4 mt-2">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">Lista tavoli</div>
                            <div class="col-12 col-sm-auto" id="exportButtons"></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="datatable">
                            <table
                                class="table table-bordered table-hover table-striped text-center display rounded nowrap"
                                id="example">
                                <thead class="thead-dark">
                                <tr class="text-center">
                                    <th></th>
                                    <th>Nome</th>
                                    <th>Persone</th>
                                    <th>Età media</th>
                                    <th>Dettagli</th>
                                    <th>Evento</th>
                                    <th>Data</th>
                                    <th>Fatto da</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($tables))
                                    @php ($c = 1)
                                    @foreach($tables as $table)
                                        @php($result = \App\Models\Eventi::getEvento($table->event_id)->first())
                                        @php($user = \Illuminate\Support\Facades\DB::table('users')->select('name', 'surname')->where('id', $table->fattoDa)->first())
                                        <tr>
                                            <td>{{$c++}}</td>
                                            <td class="text-uppercase">{{$table->nome}}</td>
                                            <td>{{$table->persone}} persone</td>
                                            <td>{{($table->etaMedia == NULL || $table->etaMedia == "/" || $table->etaMedia == " ") ? "/" : $table->etaMedia." anni"}}</td>
                                            <td>{{($table->dettagli == NULL || $table->dettagli == "/" || $table->dettagli == " ") ? "/" : $table->dettagli}}</td>
                                            <td>
                                                <a href="{{route('events.edit', $result->id)}}">{{$result->titolo}}</a>
                                            </td>
                                            <td data-sort='{{Carbon::parse($result->date)}}'>
                                                {{Carbon::parse($result->date)->format('d/m/Y')}}
                                            </td>
                                            <td>{{$user->name}} {{$user->surname}}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="#" class="btn btn-success p-3 shadow"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#table-update-{{$table->id}}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-danger p-3 shadow delete_btn"
                                                       data-bs-toggle="modal" data-bs-target="#confirm-delete"
                                                       data-descrizione="Sei sicuro di voler eliminare il tavolo <strong
                                                                        class='text-uppercase'>{{$table->nome}}</strong>?"
                                                       data-link="{{ route('delete-tavolo', $table->id) }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Update Modal -->
                                        <div class="modal fade" id="table-update-{{$table->id}}" tabindex="-1"
                                             data-bs-backdrop="static" aria-labelledby="tableUpdateModalLabel"
                                             aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="Titolo">Modifica tavolo</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <form class="form"
                                                          action="{{route('edit-tavolo', $table->id)}}"
                                                          method="post" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            @csrf
                                                            <input type="hidden" name="event_id"
                                                                   value="{{$table->event_id}}">
                                                            <div class="row mb-3">
                                                                <div class="col-md-6">
                                                                    <label for="inputNome"
                                                                           class="form-label small mb-1">Nome</label>
                                                                    <input type="text" class="form-control"
                                                                           id="inputNome"
                                                                           name="nome"
                                                                           placeholder="MARIO ROSSI"
                                                                           value="{{$table->nome}}">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="inputPersone"
                                                                           class="form-label small mb-1">Persone</label>
                                                                    <input type="number" class="form-control"
                                                                           id="inputPersone" name="persone"
                                                                           placeholder="15" value="{{$table->persone}}">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-6">
                                                                    <label for="inputEtaMedia"
                                                                           class="form-label small mb-1">Età
                                                                        media</label>
                                                                    <input type="text" class="form-control"
                                                                           id="inputEtaMedia" name="etaMedia"
                                                                           placeholder="18/19"
                                                                           value="{{$table->etaMedia}}">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="inputFattoDa"
                                                                           class="form-label small mb-1">Fatto
                                                                        da</label>
                                                                    <input type="text" class="form-control"
                                                                           name="fattoDa" list="browser"
                                                                           id="inputFattoDa"
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
                                                                           class="form-label small mb-1">Dettagli
                                                                    </label>
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
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            <!-- //Table -->
                        </div>
                    </div>
                </div>
                <!-- Tabella tavoli con bottoni -->
            </div>
        </div>
        {{--@if(basename(url()->current()) != 'filtered')
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#storeTableModal">
                        Chiudi stagione
                    </button>
                </div>
            </div>
        @endif--}}
    </div>
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
                <form action="" method="GET" id="formSubmit">
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
    {{-- <!-- Chiusura Stagione Modal -->
     <div class="modal fade" id="storeTableModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
          aria-labelledby="exampleModalLabel" aria-hidden="true" data-current-step="1">
         <div class="modal-dialog modal-dialog-centered">
             <div class="modal-content">
                 <form class="form" id="closingSeason" method="post" action="{{route('store')}}"
                       enctype="multipart/form-data">
                     @csrf
                     <div class="modal-header">
                         <h5>Chiusura tavoli stagione</h5>
                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <div class="modal-body">
                         <fieldset data-step="1">
                             <span>State per <strong>chiudere la stagione</strong> passata e tutti i relativi tavoli.
                                 Procedendo tutti i tavoli verranno rimossi e salvati in un file che sarà disponibile
                                 nella sezione <strong><em>Archivio tavoli</em></strong>.
                             </span>
                         </fieldset>
                         <fieldset data-step="2">
                             <div class="form-group row mb-3">
                                 <div class="col-sm-12">
                                     <label class="form-label" for="stagione">Inserisci il nome della stagione
                                         passata</label>
                                     <input type="text" id="stagione" name="stagione" class="form-control"
                                            placeholder='Es. "Inverno 2022/23"' required/>
                                 </div>
                             </div>
                             <div class="form-group row mb-3">
                                 <div class="col-sm-12">
                                     <label class="form-label" for="dettagli">Inserisci dettagli</label>
                                     <textarea id="dettagli" name="dettagliChiusura" class="form-control"
                                               placeholder='Inserisci dei dettagli della stagione (es. "Dal 01/01 al 31/07").'
                                               style="height: 100px"></textarea>
                                 </div>
                             </div>
                         </fieldset>
                         <fieldset data-step="3">
                             <div class="form-group row">
                                 <div class="col-sm-12 vstack gap-2">
                                     <ul class="list-group">
                                         <li class="list-group-item"><p>Stagione: <strong id="season"></strong></p></li>
                                         <li class="list-group-item"><p>Numeri tavoli:
                                                 <strong>{{$tables->count()}}</strong></p>
                                         </li>
                                         <li class="list-group-item"><p>Dettagli: <strong id="details"></strong></p></li>
                                     </ul>
                                     <strong>Sei sicuro di voler procedere?</strong>
                                 </div>
                             </div>
                         </fieldset>
                     </div>
                     <div class="modal-footer">
                         <button type="button" id="prev" class="btn btn-secondary" data-step-to="prev">
                             Precedente
                         </button>
                         <button type="button" id="button" class="btn btn-success" data-step-to="next">
                             Prossimo
                         </button>
                         <button type="submit" id="procedi" class="btn btn-info">
                             Procedi
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>--}}
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
    <script type="text/javascript" src="{{asset('assets/js/jquery.modal-wizard.min.js')}}"></script>
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
                lengthMenu: [10, 20, 30, 40, 50],
                responsive: true,
                ordering: true,
                paging: true,
                info: true,
                searching: true,
                columns: [
                    {orderable: true},
                    {
                        orderable: false, render: function (data) {
                            return data.toUpperCase()
                        }
                    },
                    {orderable: false},
                    {orderable: false},
                    {orderable: false},
                    {orderable: false},
                    {orderable: true},
                    {orderable: false},
                    {orderable: false}
                ],
                columnDefs: [
                    {responsivePriority: 1, targets: 0},
                    {responsivePriority: 2, targets: 1},
                    {responsivePriority: 3, targets: 8},
                    {responsivePriority: 4, targets: 2},
                    {responsivePriority: 5, targets: 3},
                    {responsivePriority: 6, targets: 4},
                    {responsivePriority: 10001, targets: 5},
                    {responsivePriority: 10002, targets: 6},
                    {responsivePriority: 10003, targets: 7}
                ],
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        className: 'btn btn-secondary mx-2',
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
                                            text: 'Tavoli',
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
                    },
                    {
                        extend: 'colvis',
                        text: 'Colonne',
                        className: 'btn btn-secondary'
                    }
                ]
            });
            $('.buttons-pdf').detach().appendTo('#exportButtons');
            $('.buttons-collection').detach().appendTo('#exportButtons');
            $('#storeTableModal').modalWizard();
            $(document).on('click', '#button', function () {
                let stagione = $('#stagione').val();
                let dettagli = $('#dettagli').val();
                $('#season').text("" + stagione);
                $('#details').text("" + dettagli);
            });
            $(document).on('click', '#procedi', function () {
                $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>' +
                    '<span class="sr-only">Caricamento...</span>');
                $(this).attr('disabled', 'true');
                $('#prev').attr('disabled', 'true');
                $('#closingSeason').submit();
            });
            $(document).on('click', '.delete_btn', function () {
                let link = $(this).data('link');
                let descrizione = $(this).data('descrizione');
                $('#formSubmit').attr('action', link);
                $('#confirm-delete #descrizione').html(descrizione);
            })
        });
    </script>
@endsection
