<div id="{{ $component->getDomId('show', $component->getModel()->getKey()) }}" class="x_panel ajax-overlay">
    <div class="x_content">
        {!! $component->render('include.header-panel') !!}

        <div class="row">
            <div class="col-xl-4 col-md-4 col-xs-12">
                {!! $component->render('include.general-data') !!}
                {!! $component->render('include.description-data') !!}
                {!! $component->render('include.note-data') !!}
            </div>
            <div class="col-xl-8 col-md-4 col-xs-12">
                {!! $component->render('include.attributes') !!}
            </div>
        </div>
    </div>
    <div class="x_footer">
    @can ('backAny', $component->getModel())
        <a class="btn btn-default" href="{{ $component->getController()->getRoute('index') }}"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.back') }}</a>
    @endcan
    @can ('delete', $component->getModel())
        <button data-ajax-url="{{ $component->getModel()->getControllerRoute('destroyConfirm') }}" class="btn btn-danger pull-right"><i class="fa fa-trash margin-right-10"></i>{{ $component->translate('button.delete') }}</button>
    @endcan
        {{-- @todo: any other buttons? --}}
    </div>
</div>