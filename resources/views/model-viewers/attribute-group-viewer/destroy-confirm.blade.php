<div class="x_panel ajax-overlay">
    {!! $component->render('include.header-panel') !!}

    {{ Form::open([ 'url' => $component->getController()->getRoute('destroy', $component->getModel()) ]) }}
        {{ Form::hidden('_method', 'DELETE') }}
        <div class="x_content">
            <p class="text-center">{{ $component->translate('destroy.confirmation') }} {{ $component->getModel()->getTitle() }}?</p>
        </div>

        <div class="x_footer">
            <a class="btn btn-default" href="{{ $component->getController()->getRoute('index') }}"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.back', false) }}</a>
            <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-trash-o margin-right-10"></i>{{ $component->translate('button.delete', false) }}</button>
        </div>
    {{ Form::close() }}
</div>