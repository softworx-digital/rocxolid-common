<div id="{{ $component->getDomId('show', $component->getModel()->getKey()) }}" class="x_panel ajax-overlay">
    <div class="x_content">
        {!! $component->render('include.header-panel') !!}

        <div class="row">
            <div class="col-xl-4 col-md-4 col-xs-12">
                {{-- @todo hotfixed --}}
            @if ($component->getModel()->is_negative_comparison)
                <p class="alert alert-warning">{{ $component->translate('text.negative_comparison') }}</p>
            @endif
                {!! $component->render('include.general-data') !!}
                {!! $component->render('include.description-data') !!}
                {!! $component->render('include.note-data') !!}
            </div>
            <div class="col-xl-8 col-md-4 col-xs-12">
                {!! $component->render('include.attributes') !!}
            </div>
        </div>
    </div>

    {!! $component->render('include.footer-panel') !!}
</div>