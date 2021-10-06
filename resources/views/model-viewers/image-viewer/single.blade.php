@if ($component->getModel()->isFileValid($size ?? 'mid'))
<div class="placeholder" data-image-src="{{ $component->getModel()->getControllerRoute('get', [ 'size' => $size ?? 'mid' ]) }}"@if (isset($class)) data-image-class="{{ $class }}"@endif>
    <img src="{{ $component->getModel()->base64($size ?? 'mid') }}" alt="{{ $component->getModel()->alt }}" class="img-blur loaded @if (isset($class)){{ $class }}@endif"/>
    <div style="padding-bottom: {{ 100 / $component->getModel()->getWidthHeightRatio($size ?? 'mid') }}%;"></div>
</div>
@else
<div class="alert alert-danger">Missing image file for size [{{ $size ?? 'mid' }}]!</div>
@endif