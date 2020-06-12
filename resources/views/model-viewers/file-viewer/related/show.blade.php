@can ('view', [ $component->getModel()->$relation, $attribute ])
<div id="{{ $component->getDomId($component->getModel()->$relation->getKey(), $attribute) }}" class="panel panel-default">
    {!! $component->render('related.panel-heading', [ 'relation' => $relation, 'attribute' => $attribute ] + (isset($upload_button_label) ? [ 'upload_button_label' => $upload_button_label ] : [])) !!}
    <div class="panel-body list-group text-center text-primary padding-0">
        {!! $component->render('default', [ 'file' => $component->getModel() ]) !!}
    </div>
</div>
@endcan