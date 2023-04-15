<nav class="sidenav shadow-right sidenav-light">
    <div class="sidenav-menu">
        <div class="nav accordion" id="accordionSidenav">
            {{--<!-- Sidenav Menu Heading (Account)-->
            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
            <div class="sidenav-menu-heading d-sm-none">Account</div>
            <!-- Sidenav Link (Alerts)-->
            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
            <a class="nav-link d-sm-none" href="#!">
                <div class="nav-link-icon"><i data-feather="bell"></i></div>
                Alerts
                <span class="badge bg-warning-soft text-warning ms-auto">4 New!</span>
            </a>
            <!-- Sidenav Link (Messages)-->
            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
            <a class="nav-link d-sm-none" href="#!">
                <div class="nav-link-icon"><i data-feather="mail"></i></div>
                Messages
                <span class="badge bg-success-soft text-success ms-auto">2 New!</span>
            </a>--}}

            <!-- Sidenav Menu Heading (Core)-->
            <div class="sidenav-menu-heading">Core</div>
            <!-- Sidenav Accordion (Dashboard)-->
            <a class="nav-link" href="{{route('dashboard')}}">
                <div class="nav-link-icon"><i data-feather="activity"></i></div>
                Dashboard
            </a>

            <!-- Sidenav Heading (Informazioni)-->
            <div class="sidenav-menu-heading">Controlli</div>
            @role('admin')
                <!-- Sidenav Accordion (Utenti)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                   data-bs-target="#collapseUser" aria-expanded="false" aria-controls="collapseUser">
                    <div class="nav-link-icon"><i data-feather="users"></i></div>
                    Utenti
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseUser" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        <a class="nav-link" href="{{route('users.admin')}}">Amministratori</a>
                        <a class="nav-link" href="{{route('users.pr')}}">Pr semplici</a>
                        <a class="nav-link" href="{{route('users.insert', ['page' => 'pr'])}}">Aggiungi nuovo</a>
                        <a class="nav-link" href="{{route('users.deleted')}}">Utenti non attivi</a>
                    </nav>
                </div>
                <!-- Sidenav Accordion (Eventi)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                   data-bs-target="#collapseEvents" aria-expanded="false" aria-controls="collapseEvents">
                    <div class="nav-link-icon"><i data-feather="calendar"></i></div>
                    Eventi
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseEvents" data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPagesMenu">
                        <a class="nav-link" href="{{route('events')}}">Visualizza tutti</a>
                        <a class="nav-link" href="{{route('events.insert')}}">Aggiungi nuovo</a>
                        <a class="nav-link" href="{{route('events.deleted')}}">Eventi eliminati</a>
                    </nav>
                </div>
                <!-- Sidenav Accordion (Tavoli)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                   data-bs-target="#collapseTavoli" aria-expanded="false" aria-controls="collapseTavoli">
                    <div class="nav-link-icon"><i data-feather="coffee"></i></div>
                    Tavoli
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseTavoli" data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="{{route('tavoli')}}">Cerca tutti</a>
                        <a class="nav-link" href="{{route('leaderboard')}}">Classifica pr</a>
                        <a class="nav-link" href="{{route('archivio')}}">Archivio tavoli</a>
                    </nav>
                </div>

                <!-- Sidenav Accordion (Liste)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                   data-bs-target="#collapseListe" aria-expanded="false" aria-controls="collapseListe">
                    <div class="nav-link-icon"><i data-feather="list"></i></div>
                    Liste
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseListe" data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="{{route('liste')}}">Tutte</a>
                    </nav>
                </div>
                <!-- Sidenav Accordion (Galleria)
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseGallery" aria-expanded="false" aria-controls="collapseGallery">
                    <div class="nav-link-icon"><i data-feather="film"></i></div>
                    Galleria
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseGallery" data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link disabled" href="#">Visualizza tutti</a>
                        <a class="nav-link disabled" href="#">Aggiungi nuovo</a>
                    </nav>
                </div>-->
                <!-- Sidenav Accordion (Log)-->
                <a class="nav-link" href="{{route('logs')}}">
                    <div class="nav-link-icon"><i data-feather="clipboard"></i></div>
                    Logs
                </a>
            @endrole
            @role('pr')
                <!-- Sidenav Accordion (Tavoli)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                   data-bs-target="#collapseTavoli" aria-expanded="false" aria-controls="collapseTavoli">
                    <div class="nav-link-icon"><i data-feather="coffee"></i></div>
                    Tavoli
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseTavoli" data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="{{route('tavoli_pr')}}">I tuoi tavoli</a>
                    </nav>
                </div>

                <!-- Sidenav Accordion (Liste)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                   data-bs-target="#collapseListe" aria-expanded="false" aria-controls="collapseListe">
                    <div class="nav-link-icon"><i data-feather="list"></i></div>
                    Liste
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseListe" data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="{{route('liste_pr')}}">Le tue liste</a>
                    </nav>
                </div>
            @endrole

            <!-- Sidenav Heading (App Views)-->
            <div class="sidenav-menu-heading">Altro</div>
            <!-- Sidenav Accordion (Pages)-->
            <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
               data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                <div class="nav-link-icon"><i data-feather="grid"></i></div>
                Pagine
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapsePages" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav">
                    <a class="nav-link" href="{{route('home')}}" target="_blank">Homepage</a>
                    <a class="nav-link" href="{{route('password.update')}}" target="_blank">Password dimenticata</a>
                </nav>
            </div>
        </div>
    </div>
    <!-- Sidenav Footer-->
    <div class="sidenav-footer">
        <div class="sidenav-footer-content">
            <div class="sidenav-footer-subtitle">Entrato come:</div>
            <div class="sidenav-footer-title">{{Auth::user()->username}}</div>
        </div>
    </div>
</nav>

