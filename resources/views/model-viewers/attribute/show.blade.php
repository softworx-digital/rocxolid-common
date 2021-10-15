<div id="{{ ViewHelper::domId($component, 'attribute') }}" class="x_panel ajax-overlay">
    {!! $component->render('include.header') !!}

    <div class="x_content">
        {!! $component->render('include.data') !!}
    </div>

    {!! $component->render('include.footer') !!}
</div>