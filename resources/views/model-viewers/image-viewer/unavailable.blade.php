<div class="alert alert-danger">todo model-viewers > image-viewer > unavailable.blade</div>

<div id="{{ $component->getDomId() }}" class="img img-small d-inline-block">
    {{ Html::image('vendor/softworx/rocXolid/images/user-placeholder.svg', $component->getModel()->getTitle()) }}
    <div class="btn-group show-up">
        <button class="btn btn-primary" data-ajax-url="{{ $component->getModel()->getControllerRoute('create', [ '_data[model_type]' => $model->getModelName(), '_data[model_id]' => $model->getKey() ]) }}"><i class="fa fa-pencil"></i></button>
    </div>
</div>