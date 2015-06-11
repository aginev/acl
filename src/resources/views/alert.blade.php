<!-- BEGIN ALERT MESSAGES -->
@if ($errors->all())
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h5>Form validation failed!</h5>
        <ul>
            @foreach ($errors->all() as $message)
                <li>{!! $message !!}</li>
            @endforeach
        </ul>
    </div>
@endif

@foreach (['danger', 'warning', 'success', 'info'] as $alert)
    @if (Session::has($alert))
        <div class="alert alert-{{{ $alert }}} alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <strong>{{ ucfirst($alert) }}!</strong> {{ Session::get($alert) }}
        </div>
    @endif
@endforeach
<!-- END ALERT MESSAGES -->