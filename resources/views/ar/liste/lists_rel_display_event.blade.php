@php use Carbon\Carbon; @endphp
@php use Illuminate\Support\Facades\DB; @endphp
@extends('../../ar/layouts/layout')

@section('title', 'AR | Liste')
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
                            Liste
                        </h1>
                        Liste &middot; {{$lists->count()}} totali | Totale persone {{\App\Models\Liste::getListByEventId($event->id)->sum('quantity')}}
                    </div>
                    <div class="col-auto align-items-right mb-3">
                        <button class="btn btn-sm btn-light text-primary insert-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#insert-list-modal"
                                data-link="{{route('create-lista')}}"
                                data-event="{{$event->id}}">
                            <i class="me-1" data-feather="plus"></i>
                            Aggiungi nuova
                        </button>
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
                <div class="card mb-4 mt-2">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">Liste dell'evento: <h1>{{$event->titolo}}
                                    - {{Carbon::parse($event->date)->format('d/m/Y')}}</h1></div>
                            <div class="col-12 col-sm-auto" id="exportButtons"></div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(!count($lists))
                            <div class="card-text text-center">Nessuna lista per questo evento</div>
                        @else
                            <div class="datatable">
                                <table class="table table-bordered table-hover rounded nowrap" id="example">
                                    <thead class="thead-dark">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Nome</th>
                                        <th>Persone</th>
                                        <th>Entrate</th>
                                        <th>Fatta da</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php($c = 0)
                                    @foreach($lists as $list)
                                        <tr class="text-center">
                                            <td>{{++$c}}</td>
                                            <td><strong>{{$list->surname}} {{$list->name}}</strong></td>
                                            <td>{{$list->quantity}}</td>
                                            <td>{{$list->entered}}</td>
                                            <td>{{User::getUserById($list->fatto_da)->first()->username}}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a class="btn btn-success mb-2 edit-btn"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#edit-modal"
                                                       data-link="{{route('edit-lista', $list->list_id)}}"
                                                       data-id="{{$list->list_id}}"
                                                       data-name="{{$list->name}}"
                                                       data-surname="{{$list->surname}}"
                                                       data-quantity="{{$list->quantity}}"
                                                       data-entered="{{$list->entered}}"
                                                       data-user="{{$list->fatto_da}}"
                                                       role="button">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a class="btn btn-danger mb-2 delete-btn"
                                                       data-link="{{route('delete-lista', $list->list_id)}}"
                                                       data-descrizione="Vuoi eliminare la lista <strong>{{$list->name}} {{$list->surname}}</strong>?"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#delete-modal"
                                                       role="button">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- Insert List Modal -->
    <div class="modal fade" id="insert-list-modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Aggiungi lista</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <form action="" method="POST" id="insertForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="event_id" id="event_id">
                        <label for="inputName" class="form-label">Nome lista</label>
                        <div class="mb-3 input-group">
                            <span class="input-group-text bg-gray-300" id="addon-wrapping">Cognome e nome</span>
                            <input type="text" class="form-control" name="surname"
                                   id="inputSurname" placeholder="Rossi">
                            <input type="text" class="form-control" name="name"
                                   id="inputName" placeholder="Mario">
                        </div>
                        <div class="mb-3">
                            <label for="inputPersone" class="form-label">Persone</label>
                            <input type="text" class="form-control" id="inputPersone"
                                   name="quantity" placeholder="Quante persone in lista?">
                        </div>
                        <div class="mb-3">
                            <label for="inputFattoDa" class="form-label">Fatto da</label>
                            <input type="text" class="form-control" name="fatto_da"
                                   id="inputFattoDa" placeholder="" list="fattoDa">
                            <datalist id="fattoDa">
                                @php($users_insert = DB::table('users')->get())
                                @foreach($users_insert as $user)
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
                        <input type="hidden" name="list_id" id="id">
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
                                   id="inputFattoDa" placeholder="" list="fattoDa">
                            <datalist id="fattoDa">
                                @php($users_edit = DB::table('users')->get())
                                @foreach($users_edit as $user)
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
                lengthMenu: [10, 20, 30, 40, 50],
                ordering: false,
                paging: true,
                info: true,
                searching: true,
                responsive: true,
                columnDefs: [
                    {responsivePriority: 1, targets: 0},
                    {responsivePriority: 2, targets: 1},
                    {responsivePriority: 3, targets: 5},
                    {responsivePriority: 4, targets: 2},
                    {responsivePriority: 5, targets: 3},
                    {responsivePriority: 6, targets: 4},
                ],
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        className: 'btn bt-light mx-2',
                        orientation: 'portrait',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: [1, 2]
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
                                            text: 'Lista Giovanni Celeste',
                                            fontSize: 20
                                        }
                                    ],
                                    margin: 20
                                }
                            });
                            doc.defaultStyle.noWrap = true;
                            doc.defaultStyle.fontSize = 15
                            doc.styles.tableHeader.fontSize = 18;
                            doc.styles.tableHeader.alignment = 'center';
                            doc.styles.tableBodyEven.alignment = 'center';
                            doc.styles.tableBodyOdd.alignment = 'center';
                            doc.content[0].table.widths = ['60%', '40%'];
                        },
                        text: '<i class="fas fa-file-export"></i>&nbsp;Stampa liste',
                        download: 'open'
                    }
                ]
            });
            $('.buttons-pdf').detach().appendTo('#exportButtons');
            $(document).on('click', '.insert-btn', function () {
                let link = $(this).data('link');
                let event_id = $(this).data('event');
                $('#insertForm').attr('action', link);
                $('#insertForm #event_id').val(event_id);
            });
            $(document).on('click', '.edit-btn', function () {
                let link = $(this).data('link');
                let id = $(this).data('id');
                let name = $(this).data('name');
                let surname = $(this).data('surname');
                let quantity = $(this).data('quantity');
                let entered = $(this).data('entered');
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
        });
    </script>
@endsection
