@php use Carbon\Carbon; @endphp
@extends('event.layoutSingleEvent')

@section('title', 'Evento | '.$event->titolo)
@section('image')
    {{asset('assets/img/events').'/'.$event->image}}
@endsection
@section('content')
    <div class="back-image"></div>
    <div class="container bg-text">
        @isset($event)
            <div class="row">
                <!-- Blog entries-->
                <div class="col-lg-7">
                    <!-- Featured blog post-->
                    <div class="card mb-4 text-center bg-transparent">
                        <img src="{{asset('assets/img/events').'/'.$event->image}}"
                             class="img-fluid event-image mx-auto" alt="Immagine evento {{$event->titolo}}">
                        <div class="card-body">
                            <h2 class="card-title title-event">{{$event->titolo}}</h2>
                            <h5 class="text-muted extra">{{$event->extra}}</h5>
                            <p class="card-text discoteca">@if($event->discoteca != null)
                                    <i
                                        class="fas fa-map-marker-alt"></i> {{$event->discoteca}}
                                @endif</p>
                            <div class="countdown-container">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if($event->date != null)
                                                <div id="countdown"></div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Side widgets-->
                <div class="col-lg-5">
                    <!-- Side widget-->
                    <div class="card mb-4 bg-transparent card-detail">
                        <div class="card-header">Dettagli</div>
                        <div class="card-body">
                            <p class="text-capitalize data"><i
                                    class="far fa-calendar-alt"></i>@if($event->date != null)
                                    {{Carbon::parse($event->date)->dayName}}
                                    , {{Carbon::parse($event->date)->format('d/m/Y')}}
                                @endif</p>
                            <p class="text-capitalize data"><i
                                    class="far fa-clock"></i>@if($event->date != null)
                                    {{Carbon::parse($event->date)->format('H:i')}}
                                @endif
                            </p>
                            <p class="descrizione" style="color: white!important">{!! $event->descrizione !!}</p>
                            @if($event->date != null)
                                <a href="tel:+39 333 628 6402" class="btn btn-event mr-2"><i
                                        class="fas fa-info-circle"></i> MAGGIORI INFORMAZIONI</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endisset
    </div>
@endsection
