<div id="{{ $component->getDomId('attribute-group') }}" class="x_panel ajax-overlay">
    {!! $component->render('include.header-panel') !!}

    <div class="x_content">
        {!! $component->render('include.data') !!}
        {!! $component->render('include.attributes') !!}
    </div>

    {!! $component->render('include.footer-panel') !!}
</div>