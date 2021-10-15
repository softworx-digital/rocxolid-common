<div class="col-md-4 col-xs-12 text-right">
{{-- @todo hotfixed --}}
@if (\Route::has('rocXolid.app.exception'))
<div class="btn-group btn-group-vertical">
    <a class="btn btn-warning" href="{{ route('rocXolid.app.exception') }}" target="_blank"><i class="fa fa-bolt margin-right-10"></i>Vytvoriť chybu v novom okne</a>
    <a class="btn btn-warning" data-ajax-url="{{ route('rocXolid.app.exception') }}"><i class="fa fa-bolt margin-right-10"></i>Vytvoriť chybu cez AJAX request</a>
</div>
@endif
</div>