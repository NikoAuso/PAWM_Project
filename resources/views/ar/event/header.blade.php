<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="list"></i></div>
                        Eventi
                    </h1>Lista eventi &middot; {{$events->count()}} totali
                </div>
                <div class="col-auto btn-toolbarcol mb-3" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group mx-1" role="group" aria-label="Second group">
                        <a type="button" class="btn btn-primary" href="{{route('events')}}#grid" onclick="gridView()"><i class="fas fa-grip-vertical"></i></a>
                        <a type="button" class="btn btn-primary" href="{{route('events')}}#list" onclick="listView()"><i class="fas fa-list-ul"></i></a>
                    </div>
                    <div class="btn-group mx-1" role="group" aria-label="Third group">
                        <a type="button" class="btn btn-primary" href="{{route('events.table')}}"><i class="fas fa-table"></i></a>
                    </div>
                    <div class="btn-group mx-1" role="group" aria-label="Third group" id="calendarBtn">
                        <a type="button" class="btn btn-primary" href="{{route('events.calendar')}}"><i class="far fa-calendar-alt"></i></a>
                    </div>
                </div>
                <div class="col-auto align-items-right mb-3">
                    <a class="btn btn-sm btn-light text-primary" href="{{route('events.insert')}}">
                        <i class="me-1" data-feather="plus"></i>
                        Aggiungi nuovo
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
