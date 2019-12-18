<div id="{{ $component->getDomId() }}" class="img img-small d-inline-block">
    {!! $component->render('include.data', [ 'size' => $size ]) !!}
@if ($component->getModel()->userCan('write'))
    <div class="btn-group show-up">
        <button class="btn btn-primary" data-ajax-url="{{ $component->getModel()->getControllerRoute('edit') }}"><i class="fa fa-pencil"></i></button>
        <button class="btn btn-danger" data-ajax-url="{{ $component->getModel()->getControllerRoute('destroyConfirm') }}"><i class="fa fa-trash"></i></button>
    </div>
@endif
</div>