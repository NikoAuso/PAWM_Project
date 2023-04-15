<div class="col">
    <div class="card-wrapper text-center">
        <div class="card h-100">
            <div class="img-responsive-wrapper">
                <div class="img-responsive">
                    <figure class="img-wrapper">
                        <img src='{{asset('assets/img/events/').'/'.$event->image}}'
                             class='card-img-top rounded card-event-img' loading="lazy"
                             alt='Copertina {{$event->titolo}}'/>
                    </figure>
                </div>
                <div class="img-overlay">
                    @if(!$event->isJolly)
                        <a class="btn btn-warning mb-2"
                           href="{{route('tavoli.event', ['id' => $event->id])}}">
                            <i class="fas fa-glass-martini-alt"></i>
                        </a>
                        <a class="btn btn-success mb-2" href="{{route('liste.event', ['id' => $event->id])}}">
                            <i class="fa-solid fa-list-check"></i>
                        </a>
                    @endif
                    @if($event->active)
                        <a class="btn btn-secondary mb-2" href="{{route('singleEvent', [$event->id])}}" target="_blank">
                            <i class="fas fa-eye"></i>
                        </a>
                    @else
                        <button type="button" class="btn btn-info mb-2" data-bs-toggle="modal"
                                data-bs-target="#eventModal"
                                data-bs-id="{{$event->id}}">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    @endif
                    <a class="btn btn-primary mb-2" href="{{route('events.edit', ['id' => $event->id])}}">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
            </div>
            <div class="card-body card-event-body">
                <!-- Data-->
                @if($event->date != null)
                    <h5 class="card-title text-capitalize">
                        <b>{{Carbon::parse($event->date)->format('d/m/Y')}}</b>
                    </h5>
                @endif
                <!-- Titolo-->
                @if($event->titolo != null)
                    <h2>{!! $event->titolo !!}</h2>
                @endif
                <!-- Titolo 2-->
                @if($event->extra != null)
                    <h4><i>{{$event->extra}}</i></h4>
                @endif
                <!-- Countdown-->
                @if($event->date != null && strtotime($event->date) > strtotime(date(now())))
                    <h5>
                        <span class='countdown' value='{{$event->date}}'></span>
                    </h5>
                @endif
                <!-- Tavoli-->
                @if(!$event->isJolly)
                    <h4><strong>TAVOLI</strong>: {{DB::table('tavoli_eventi')->where('event_id', $event->id)->count()}}
                    </h4>
                @endif
                <!-- Pagato-->
                @if(!$event->isJolly)
                    <h4>
                        <strong>PAGATO</strong>: {!! (!$event->pagato) ? '<i class="fas fa-times text-danger"></i>' : '<i class="fas fa-check text-success"></i>' !!}
                    </h4>
                @endif
            </div>
            <div class="card-footer">
                <span>
                    <small
                        class="text-muted">Modificato:</small>
                </span>
                <br/>
                <span>
                    <small class="text-muted">{{\App\Models\User::getUserById($event->updated_by)->first()->username}}</small>
                </span>
                <br/>
                <span>
                    <small
                        class="text-muted">{{Carbon::parse($event->updated_at)->formatLocalized('%e/%m/%Y %H:%M')}}</small>
                </span>
            </div>
        </div>
    </div>
</div>
