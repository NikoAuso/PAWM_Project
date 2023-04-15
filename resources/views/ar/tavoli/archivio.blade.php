@php use Illuminate\Support\Facades\File; @endphp
@extends('../../ar/layouts/layout')

@section('title', 'AR | Archivio tavoli')

@section('content')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">Archivio tavoli</h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4">
        @foreach($archivio as $stagione)
            @if(File::exists(public_path() . '/assets/archivio/' . $stagione->pdf_tavoli) &&
File::exists(public_path() . '/assets/archivio/' . $stagione->pdf_classifica) &&
File::exists(public_path() . '/assets/archivio/' . $stagione->csv_tavoli))
                <h2 class="mb-0 mt-5">{{$stagione->nome_stagione}}</h2>
                <small>{{$stagione->dettagli}}</small>
                <hr class="mt-2 mb-4"/>
                <div class="row my-3">
                    <div class="col-md-4">
                        <div class="card text-center h-100">
                            <div class="card-body">
                                <h2 class="card-text">
                                    <i class="fa-solid fa-file-pdf fa-3x"></i>
                                </h2>
                                <h4 class="card-text">
                                    {{$stagione->nome_stagione}}.pdf
                                </h4>
                            </div>
                            <a href="{{asset('assets/archivio/' . $stagione->pdf_tavoli)}}"
                               download>
                                <div class="card-footer bg-primary">
                                    <div class="col-12">
                                        <i class="fa-solid fa-file-arrow-down text-white fa-1x"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center h-100">
                            <div class="card-body">
                                <h2 class="card-text">
                                    <i class="fa-solid fa-file-pdf fa-3x"></i>
                                </h2>
                                <h4 class="card-text">
                                    Classifica {{$stagione->nome_stagione}}.pdf
                                </h4>
                            </div>
                            <a href="{{asset('assets/archivio/' . $stagione->pdf_classifica)}}"
                               download>
                                <div class="card-footer bg-primary">
                                    <div class="col-12">
                                        <i class="fa-solid fa-file-arrow-down text-white fa-1x"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center h-100">
                            <div class="card-body">
                                <h2 class="card-text">
                                    <i class="fa-solid fa-file-csv fa-3x"></i>
                                </h2>
                                <h4 class="card-text">
                                    {{$stagione->nome_stagione}}.csv
                                </h4>
                            </div>
                            <a href="{{asset('assets/archivio/' . $stagione->csv_tavoli)}}"
                               download>
                                <div class="card-footer bg-primary">
                                    <div class="col-12">
                                        <i class="fa-solid fa-file-arrow-down text-white fa-1x"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="row my-3">
                    <div class="alert alert-danger" role="alert">
                        <strong>Errore</strong>: i file non esistono.
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endsection
