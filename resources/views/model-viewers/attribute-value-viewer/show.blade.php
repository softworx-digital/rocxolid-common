<div id="{{ ViewHelper::domId($component, 'attribute') }}" class="x_panel ajax-overlay">
    {!! $component->render('include.header-panel') !!}

    <div class="x_content">
        {!! $component->render('include.data') !!}
    </div>

    <div class="x_footer">
        <a class="btn btn-default" href="{{ $component->getController()->getRoute('index') }}"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.back') }}</a>
    @if ($component->getModel()->userCan('write'))
        <a href="{{ $component->getModel()->getControllerRoute('edit') }}" class="btn btn-primary pull-right"><i class="fa fa-pencil margin-right-10"></i>{{ $component->translate('button.edit') }}</a>
    @endif
    </div>
</div>