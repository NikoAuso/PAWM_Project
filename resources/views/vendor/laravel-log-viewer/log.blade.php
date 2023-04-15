@extends('ar.layouts.layout')

@section('title', 'AR | Logs')
@section('link')
    <link href="{{asset('assets/bootstrap/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/bootstrap/css/responsive.bootstrap5.min.css')}}" rel="stylesheet">
@endsection
@section('content')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="list"></i></div>
                            Attività
                        </h1>
                        <div class="page-header-subtitle">Controlla le attività degli utenti</div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container mt-n10">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 mb-4">
                <div class="card h-100">
                    <div class="card-body h-100 p-5">
                        <div class="datatable table-container">
                            @if ($logs === null)
                                <div>
                                    Log file >50M, please download it.
                                </div>
                            @else
                                <table class="table table-bordered table-striped text-center
                                            dataTable display rounded align-middle" id="example">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th style="white-space: nowrap">Livello</th>
                                        <th style="white-space: nowrap">Data</th>
                                        <th>Contenuto</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($logs as $key => $log)
                                        <tr data-display="stack{{{$key}}}">
                                            @if ($standardFormat)
                                                <td class="text-{{{$log['level_class']}}}">
                                                        <span class="fa fa-{{{$log['level_img']}}} fa-2x"
                                                              aria-hidden="true" data-bs-toggle="tooltip"
                                                              data-bs-title="{{$log['level']}}">
                                                        </span>
                                                </td>
                                                <td style="font-size: 14px; white-space: nowrap">
                                                    {{\Carbon\Carbon::parse($log['date'])->format('d/m/Y h:i:s')}}
                                                </td>
                                                <td style="white-space: initial; word-wrap: break-word">
                                                    <p>
                                                        {!! $log['text'] !!}
                                                    </p>
                                                </td>
                                                <td>
                                                    @if ($log['stack'])
                                                        <button type="button" class="btn btn-outline-dark btn-sm"
                                                                data-display="stack{{{$key}}}"
                                                                data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                                data-logs="{{{ trim($log['stack']) }}}">
                                                            <span class="fa fa-search"></span>
                                                        </button>
                                                    @endif
                                                </td>
                                            @else
                                                <td colspan="4">Nessun log registrato</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                            <div class="p-3">
                                @if($current_file)
                                    <a href="?dl={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                                        <span class="fa fa-download"></span> Scarica file
                                    </a>
                                    -
                                    <a id="clean-log"
                                       href="?clean={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                                        <span class="fa fa-sync"></span> Pulisci logs
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Stacktrace</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="modal-text-logs" style="white-space: pre-wrap;"></p>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{asset('assets/bootstrap/js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/bootstrap/js/dataTables.bootstrap5.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/bootstrap/js/dataTables.responsive.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#exampleModal').on('show.bs.modal', function (e) {

                //get data-id attribute of the clicked element
                let text = $(e.relatedTarget).data('logs');

                //populate the textbox
                $('#modal-text-logs').html(text);
            });
            $('#example').DataTable({
                lengthMenu: [5, 10, 20, 30],
                responsive: true,
                ordering: false,
                order: [{{($standardFormat) ? 1 : 0}}, 'desc'],
                paging: true,
                searching: true,
                stateSaveCallback: function (settings, data) {
                    window.localStorage.setItem("datatable", JSON.stringify(data));
                },
                stateLoadCallback: function () {
                    let data = JSON.parse(window.localStorage.getItem("datatable"));
                    if (data) data.start = 0;
                    return data;
                }
            });
        });
    </script>
@endsection
