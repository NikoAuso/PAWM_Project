<!-- Event Card-->
<div class="container content">
    <h1 id="next-event" class="title row" data-aos="zoom-in" data-aos-delay="200" data-aos-duration="700">
        PROSSIMI EVENTI
    </h1>
    <hr class="next-event-hr" data-aos="fade-down" data-aos-delay="200" data-aos-duration="700">
    <div class="d-flex justify-content-center">
        <div
            class="row row-cols-1 row-cols-lg-{{$active}} row-cols-md-{{($active == 1) ? $active : 3}} row-cols-sm-{{($active == 1) ? $active : 2}} g-4">
            @foreach($home_events as $event)
                <div class="col">
                    <div class="card card-event" data-aos="flip-right" data-aos-duration="700"
                         data-aos-delay="300">
                        <img src="{{asset('assets/img/events').'/'.$event->image}}" class="card-img-top"
                             alt="Copertina evento {{$event->titolo}}">
                        <div class="card-body">
                            <p class="card-title">{{$event->titolo}}</p>
                            <p class="card-subtitle mb-2 text-muted">{{$event->extra}}</p>
                            @if($event->date != null)
                                <p class="card-date text-uppercase"><i
                                        class="fas fa-calendar-alt"></i> {{\Carbon\Carbon::parse($event->date)->dayName}}
                                    , {{\Carbon\Carbon::parse($event->date)->format('d/m/Y')}}
                                </p>
                            @endif
                        </div>
                        <div class="card-footer text-center">
                            <a type="button" class="btn btn-outline-white btn-event float-left"
                               data-mdb-color="dark"
                               href="{{route('singleEvent', [$event->id])}}">
                                <i class="fas fa-info-circle"></i> Info evento
                            </a>
                            <a type="button" class="btn btn-outline-white btn-event float-right"
                               data-mdb-color="dark"
                               href="tel:+39 333 628 6402">
                                <i class="far fa-comments"></i> Contattaci
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
