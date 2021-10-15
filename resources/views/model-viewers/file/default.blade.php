@if (isset($file))
    @if ($file->isMimeType('application/pdf'))
        <div class="pdfobject" data-pdf-url="{{ $file->getControllerRoute('get') }}"></div>
    @elseif ($file->isMimeType('image/*'))
        <div class="img img-download">
            <a href="{{ $file->getControllerRoute('download') }}" download="{{ $file->getControllerRoute('download') }}"><img src="{{ $file->getControllerRoute('get') }}" alt="{{ $file->title }}" class="width-100"/></a>
        </div>
    @else
        <a class="list-group-item list-group-item-action" href="{{ $file->getControllerRoute('download') }}" download="{{ $file->getControllerRoute('download') }}">{{ $file->getTitle() }}</a>
    @endif
@else
    <div class="list-group-item alert alert-danger">[{{ $view_name }}] specify file!</div>
@endif