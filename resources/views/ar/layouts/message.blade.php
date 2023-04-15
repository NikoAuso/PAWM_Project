@if(Session::has('message'))
    {!! '<div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <h5 class="alert-heading">Ottimo</h5>'. Session::get('message').'
                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
         </div>' !!}
@endif
@if(Session::has('errors'))
    @foreach($errors->all() as $error)
        {!! '<div class="container mt-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h5 class="alert-heading">Oops!</h5>'!!} {!! $error !!} {!!'
                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>' !!}
    @endforeach
@endif
@if(Session::has('info'))
    {!! '<div class="container mt-3">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <h5 class="alert-heading">Info!</h5>'. Session::get('info').'
                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>' !!}
@endif
