<div id="{{ $component->getDomId('output') }}">
@if ($assignments->has('output'))
    <div class="well"><pre>{!! $assignments->get('output') !!}</pre></div>
@endif
</div>