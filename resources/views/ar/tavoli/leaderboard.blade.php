@extends('../../ar/layouts/layout')

@section('title', 'AR | Classifica')
@section('link')
    <link href="{{asset('assets/bootstrap/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/bootstrap/css/responsive.bootstrap5.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/bootstrap/css/buttons.bootstrap5.min.css')}}" rel="stylesheet">
@endsection
@section('content')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">Classifica</h1>
                        <div class="page-header-subtitle">Classifica tavoli &middot; aggiornata
                            al {{\Carbon\Carbon::parse($date->date)->format('d/m/Y')}}</div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <div class="row">
            <div class="col-xl-12 col-sm-12 mb-12">
                <div class="card card-waves mb-4 mt-2">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">Classifica tavoli pr</div>
                            <div class="col-12 col-sm-auto" id="exportButtons"></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="datatable">
                            <table class="table table-bordered table-hover table-striped text-center display rounded"
                                   id="example">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Pos.</th>
                                    <th>Nome</th>
                                    <th>Cognome</th>
                                    <th>Username</th>
                                    <th>Numero tavoli</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php ($c = 1)
                                @foreach($result as $data)
                                    @if($data->fattoDa == "ACCOUNT ONELOVE")
                                        @php($data = null)
                                    @endif
                                    @php($user = (new \App\Models\User)->getUserById($data->fattoDa)->values()->get(0))
                                    <tr>
                                        <td>{{$c++}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->surname}}</td>
                                        <td>{{$user->username}}</td>
                                        <td>{{$data['count']}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <!-- //Table -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection
        @section('scripts')
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
                        ordering: false,
                        paging: false,
                        info: false,
                        searching: false,
                        buttons: [
                            {
                                extend: 'pdfHtml5',
                                className: 'btn bt-light mx-2',
                                message: 'Classifica aggiornata al ' + '@php(print_r(\Carbon\Carbon::parse($date->date)->format('d/m/Y')))',
                                orientation: 'portrait',
                                pageSize: 'A4',
                                exportOptions: {
                                    columns: [0, 1, 2, 4]
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
                                                    text: 'Classifica tavoli pr',
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
                                    doc.content[1].table.widths = ['*', '*', '*', '*'];
                                    console.log(doc.content[1].table);
                                    for (let i = 1; i < doc.content[1].table.body.length; i++) {
                                        let name = doc.content[1].table.body[i][1].text;
                                        doc.content[1].table.body[i][1].text = name.toUpperCase();
                                        let surname = doc.content[1].table.body[i][2].text;
                                        doc.content[1].table.body[i][2].text = surname.toUpperCase();
                                    }
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
