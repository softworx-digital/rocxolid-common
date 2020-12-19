@can ('view', [ $component->getModel()->$relation, $attribute ])
<div id="{{ $component->getDomId(md5(get_class($component->getModel()->$relation)), $component->getModel()->$relation->getKey(), $attribute) }}" class="panel panel-default">
    {!! $component->render('related.panel-heading', [
        'relation' => $relation,
        'attribute' => $attribute,
        'read_only' => $read_only ?? false,
    ] + (isset($upload_button_label) ? [ 'upload_button_label' => $upload_button_label ] : [])) !!}
    <div class="panel-body text-center text-primary padding-0">
        {!! $component->render('default', [ 'image' => $component->getModel(), 'size' => $size ?? 'mid' ]) !!}
    </div>
</div>
@endcan