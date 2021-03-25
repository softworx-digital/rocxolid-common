@if (isset($image) && isset($size))
@if ($image->isFileValid($size))
<div class="placeholder" data-image-src="{{ $image->getControllerRoute('get', [ 'size' => $size ]) }}"@if (isset($class)) data-image-class="{{ $class }}"@endif>
    <img src="{{ $image->base64($size) }}" alt="{{ $image->alt }}" class="img-blur loaded @if (isset($class)){{ $class }}@endif"/>
    <div style="padding-bottom: {{ 100 / $image->getWidthHeightRatio($size) }}%;"></div>
</div>
@else
@endif
@else
<div class="alert alert-danger">[{{ $view_name }}] specify image &amp; image size!</div>
@endif