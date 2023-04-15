@extends('ar/layouts.layout')

@section('title', 'Dashboard')
@section('content')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="activity"></i></div>
                            Dashboard
                        </h1>
                        <div class="page-header-subtitle">Comandi principali</div>
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
                        <div class="row align-items-center">
                            <div class="col-xl-8 col-xxl-8">
                                <div class="text-left text-xl-start text-xxl-left mb-4 mb-xl-0 mb-xxl-4">
                                    <h1 class="text-primary">Benvenuti nell'area riservata!</h1>
                                    <p class="text-gray-700 mb-0">Novità
                                        dell'aggiornamento {{config('app.version')}}</p>
                                    <ul>
                                        <li>Risoluzione bug</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xl-4 col-xxl-4 text-center">
                                <img class="img-fluid" src="{{asset('assets/img/illustrations/at-work.svg')}}"
                                     style="max-width: 26rem" alt=""/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @role('admin')
            <div class="col-xxl-3 col-lg-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-3">
                                <div class="text-white-75 small">Utenti</div>
                                <div class="text-lg font-weight-bold">{{$allUser}} Pr registrati</div>
                                <div class="text-lg font-weight-bold">{{$inactiveUser}} Pr non attivi</div>
                            </div>
                            <i class="fa fa-users fa-5x"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{route('users.pr')}}">Vedi dettagli</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            @endrole
            @role('admin')
            <div class="col-xxl-3 col-lg-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-3">
                                <div class="text-white-75 small">Eventi</div>
                                <div class="text-lg font-weight-bold">{{$allEvents}} Eventi totali</div>
                                <div class="text-lg font-weight-bold">{{$deletedEvents}} Eliminati</div>
                            </div>
                            <i class="fa fa-table fa-5x"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{route('events')}}">Vedi dettagli</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            @endrole
            @role('admin|pr')
            <div class="col-xxl-3 col-lg-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-3">
                                <div class="text-white-75 small">Liste</div>
                                <div class="text-lg font-weight-bold">{{$allListe}} Liste</div>
                            </div>
                            <i class="fa-solid fa-list-check fa-5x"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link"
                           href="{{\Illuminate\Support\Facades\Auth::user()->getRoleNames()->get(0) == 'admin' ? route('liste') : route('liste_pr')}}">Vedi
                            dettagli</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            @endrole
            @role('admin|pr')
            <div class="col-xxl-3 col-lg-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-3">
                                <div class="text-white-75 small">Tavoli</div>
                                <div class="text-lg font-weight-bold">{{$allTavoli}} Tavoli</div>
                            </div>
                            <i class="fas fa-glass-martini-alt fa-5x"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link"
                           href="{{\Illuminate\Support\Facades\Auth::user()->getRoleNames()->get(0) == 'admin' ? route('tavoli') : route('tavoli_pr')}}">Vedi
                            dettagli</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            @endrole
        </div>
    </div>
    <!-- End of Main page-->
@endsection
@if(\Carbon\Carbon::parse(\Illuminate\Support\Facades\Auth::user()->birthday)->day == today()->day && !isset($_COOKIE['birthday']))
    @section('link')
        <style>
            .modal-body {
                margin: 0;
                background: #020202;
                cursor: crosshair;
                overflow: hidden;
                padding: 0;
                height: 100vh;
            }

            canvas {
                display: block
            }

            .birthday-text {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                color: #fff;
                font-family: "Metropolis", sans-serif;
                font-size: 8vw;
                font-weight: 900;
                -webkit-user-select: none;
                user-select: none;
            }
        </style>
    @endsection
    @section('scripts')
        <!-- Modal -->
        <div class="modal fade" id="happyBirthday" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="happyBirthday" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="btn-close btn-close-white" style="width: 2em;height: 2em;"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                        <span class="birthday-text text-nowrap">&#127881; Tanti auguri! &#127881;</span>
                        <canvas id="birthday"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // helper functions
            const PI2 = Math.PI * 2
            const random = (min, max) => Math.random() * (max - min + 1) + min | 0
            const timestamp = _ => new Date().getTime()

            // container
            class Birthday {
                constructor() {
                    this.resize()

                    // create a lovely place to store the firework
                    this.fireworks = []
                    this.counter = 0

                }

                resize() {
                    this.width = canvas.width = window.innerWidth
                    let center = this.width / 2 | 0
                    this.spawnA = center - center / 4 | 0
                    this.spawnB = center + center / 4 | 0

                    this.height = canvas.height = window.innerHeight
                    this.spawnC = this.height * .1
                    this.spawnD = this.height * .5

                }

                onClick(evt) {
                    let x = evt.clientX || evt.touches && evt.touches[0].pageX
                    let y = evt.clientY || evt.touches && evt.touches[0].pageY

                    let count = random(3, 5)
                    for (let i = 0; i < count; i++) this.fireworks.push(new Firework(
                        random(this.spawnA, this.spawnB),
                        this.height,
                        x,
                        y,
                        random(0, 260),
                        random(30, 110)))

                    this.counter = -1

                }

                update(delta) {
                    ctx.globalCompositeOperation = 'hard-light'
                    ctx.fillStyle = `rgba(20,20,20,${7 * delta})`
                    ctx.fillRect(0, 0, this.width, this.height)

                    ctx.globalCompositeOperation = 'lighter'
                    for (let firework of this.fireworks) firework.update(delta)

                    // if enough time passed... create new new firework
                    this.counter += delta * 3 // each second
                    if (this.counter >= 1) {
                        this.fireworks.push(new Firework(
                            random(this.spawnA, this.spawnB),
                            this.height,
                            random(0, this.width),
                            random(this.spawnC, this.spawnD),
                            random(0, 360),
                            random(30, 110)))
                        this.counter = 0
                    }

                    // remove the dead fireworks
                    if (this.fireworks.length > 1000) this.fireworks = this.fireworks.filter(firework => !firework.dead)

                }
            }

            class Firework {
                constructor(x, y, targetX, targetY, shade, offsprings) {
                    this.dead = false
                    this.offsprings = offsprings

                    this.x = x
                    this.y = y
                    this.targetX = targetX
                    this.targetY = targetY

                    this.shade = shade
                    this.history = []
                }

                update(delta) {
                    if (this.dead) return
                    let xDiff = this.targetX - this.x
                    let yDiff = this.targetY - this.y
                    if (Math.abs(xDiff) > 3 || Math.abs(yDiff) > 3) { // is still moving
                        this.x += xDiff * 2 * delta
                        this.y += yDiff * 2 * delta

                        this.history.push({
                            x: this.x,
                            y: this.y
                        })

                        if (this.history.length > 20) this.history.shift()

                    } else {
                        if (this.offsprings && !this.madeChilds) {

                            let babies = this.offsprings / 2
                            for (let i = 0; i < babies; i++) {
                                let targetX = this.x + this.offsprings * Math.cos(PI2 * i / babies) | 0
                                let targetY = this.y + this.offsprings * Math.sin(PI2 * i / babies) | 0

                                birthday.fireworks.push(new Firework(this.x, this.y, targetX, targetY, this.shade, 0))

                            }

                        }
                        this.madeChilds = true
                        this.history.shift()
                    }

                    if (this.history.length === 0) this.dead = true
                    else if (this.offsprings) {
                        for (let i = 0; this.history.length > i; i++) {
                            let point = this.history[i]
                            ctx.beginPath()
                            ctx.fillStyle = 'hsl(' + this.shade + ',100%,' + i + '%)'
                            ctx.arc(point.x, point.y, 1, 0, PI2, false)
                            ctx.fill()
                        }
                    } else {
                        ctx.beginPath()
                        ctx.fillStyle = 'hsl(' + this.shade + ',100%,50%)'
                        ctx.arc(this.x, this.y, 1, 0, PI2, false)
                        ctx.fill()
                    }

                }
            }

            let canvas = document.getElementById('birthday')
            let ctx = canvas.getContext('2d')

            let then = timestamp()

            let birthday = new Birthday
            window.onresize = () => birthday.resize()
            document.onclick = evt => birthday.onClick(evt)
            document.ontouchstart = evt => birthday.onClick(evt)

            ;(function loop() {
                requestAnimationFrame(loop)

                let now = timestamp()
                let delta = now - then

                then = now
                birthday.update(delta / 1000)
            })()

            let happyBirthday = new bootstrap.Modal(document.getElementById('happyBirthday'));
            happyBirthday.show()
            $(document).on('hidden.bs.modal', happyBirthday, function (event) {
                document.cookie = "birthday=true";
            });
        </script>
    @endsection
@endif
