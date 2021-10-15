@can ('view', [ $component->getModel()->$relation, $attribute ])
<div id="{{ $component->getDomId(md5(get_class($component->getModel()->$relation)), $component->getModel()->$relation->getKey(), $attribute) }}" class="panel panel-default">
    {!! $component->render('related.include.panel-heading', [
        'relation' => $relation,
        'attribute' => $attribute,
        'read_only' => $read_only ?? false,
    ]) !!}
    <div class="panel-body text-center text-primary padding-0" style="position: relative;">
        {!! $component->render('default', [ 'image' => $component->getModel(), 'size' => $size ?? 'mid' ]) !!}

        {{-- @todo hotfixed --}}
        @foreach ($draggables ?? [] as $draggable)
        <div class="resize-drag"
            data-x="{{ $draggable->floorplan_x }}"
            data-y="{{ $draggable->floorplan_y }}"
            data-width="{{ $draggable->floorplan_width }}"
            data-height="{{ $draggable->floorplan_height }}"
            data-update-url="{{ $draggable->getControllerRoute('setDraggablePosition') }}"
            style="
                position: absolute;
                top: {{ $draggable->floorplan_y }}px;
                left: {{ $draggable->floorplan_x }}px;
                width: {{ $draggable->floorplan_width }}px;
                height: {{ $draggable->floorplan_height }}px;
                border-radius: 8px; border: 3px dashed #000; padding: 0; background-color: rgba(72, 255, 0, 0.4); color: white; text-shadow: 0 0 2px #000; font-size: 15px; touch-action: none; box-sizing: border-box;">
            {{ $draggable->getTitle() }}
        </div>
        @endforeach
    </div>
    {!! $component->render('related.include.panel-footer', [
        'relation' => $relation,
        'attribute' => $attribute,
        'read_only' => $read_only ?? false,
    ] + (isset($upload_button_label) ? [ 'upload_button_label' => $upload_button_label ] : [])) !!}
</div>
@endcan