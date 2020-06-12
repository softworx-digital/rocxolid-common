@if (isset($file))
    <a class="list-group-item list-group-item-action" href="{{ $file->getControllerRoute('get') }}" download="{{ $file->getControllerRoute('get') }}">{{ $file->getTitle() }}</a>
@else
    <div class="list-group-item alert alert-danger">[{{ $view_name }}] specify file!</div>
@endif