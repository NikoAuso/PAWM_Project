<div class="col-md-12" style="padding-bottom: 10px;">
    <div class="card mb-3 card-horizontal">
        <div class="row g-0 justify-content-between">
            <div class="col-md-4">
                <img src='{{asset('assets/img/events/').'/'.$event->image}}' loading="lazy" class='card-img-top rounded'
                     alt='Copertina {{$event->titolo}}'/>
            </div>
            <div class="col-md-6">
                <div class="card-body">
                    <div class="row g-0">
                        <div class="col-md-6">
                            <!-- Data-->
                            @if($event->date != null)
                                <h5 class="card-title text-capitalize">
                                    <b>{{Carbon::parse($event->date)->format('d/m/Y')}}</b>
                                </h5>
                            @endif
                            <!-- Titolo-->
                            @if($event->titolo != null)
                                <h2 class="card-title text-truncate" style="max-height: 120px">{!! $event->titolo !!}</h2>
                            @endif
                            <!-- Titolo 2-->
                            @if($event->extra != null)
                                <h4 class="card-text"><i>{{$event->extra}}</i></h4>
                            @endif
                        </div>
                        <div class="col-md-5">
                            <!-- Tavoli-->
                            @if(!$event->isJolly)
                                <h4>
                                    <strong>TAVOLI</strong>: {{DB::table('tavoli_eventi')->where('event_id', $event->id)->count()}}
                                </h4>
                            @endif
                            <!-- Pagato-->
                            @if(!$event->isJolly)
                                <h4>
                                    <strong>PAGATO</strong>: {!! (!$event->pagato) ? '<i class="fas fa-times text-danger"></i>' : '<i class="fas fa-check text-success"></i>' !!}
                                </h4>
                            @endif
                        </div>
                    </div>
                    <div class="row g-0">
                        <!-- Countdown-->
                        @if($event->date != null && strtotime($event->date) > strtotime(date(now())))
                            <h5>
                                <span class='countdown' value='{{$event->date}}'></span>
                            </h5>
                        @endif
                    </div>
                    <div class="row g-0" style="position: absolute; bottom: 0" id="data_modified">
                        <div>
                            <p class="text-muted">Modificato: {{\App\Models\User::getUserById($event->updated_by)->first()->username}}
                                - {{Carbon::parse($event->updated_at)->formatLocalized('%e/%m/%Y %H:%M')}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-lg-1 text-center" id="action-btn-event">
                @if(!$event->isJolly)
                    <a class="btn btn-warning mb-2" href="{{route('tavoli', ['id' => $event->id])}}">
                        <i class="fas fa-glass-martini-alt"></i>
                    </a>
                    <a class="btn btn-success mb-2" href="{{route('liste.event', ['id' => $event->id])}}">
                        <i class="fa-solid fa-list-check"></i>
                    </a>
                @endif
                @if($event->active)
                    <a class="btn btn-secondary mb-2" target="_blank" href="{{route('singleEvent', [$event->id])}}">
                        <i class="fas fa-eye"></i>
                    </a>
                @else
                    <button type="button" class="btn btn-info mb-2" data-bs-toggle="modal" data-bs-target="#eventModal"
                            data-bs-id="{{$event->id}}">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                @endif
                <a class="btn btn-primary mb-2" href="{{route('events.edit', ['id' => $event->id])}}">
                    <i class="fas fa-edit"></i>
                </a>
            </div>
        </div>
    </div>
</div>
