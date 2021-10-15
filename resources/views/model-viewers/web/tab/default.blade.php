<div class="row">
    <div class="col-xl-8 col-md-6 col-xs-12">
        <div class="row">
            {!! $component->render('panel.default', [ 'param' => 'data.general' ]) !!}
            {!! $component->render('panel.single', [ 'param' => 'data.description' ]) !!}
        </div>
    </div>
    <div class="col-xl-4 col-md-6 col-xs-12">
        <div class="row">
            {!! $component->render('panel.default', [ 'param' => 'data.localization' ]) !!}
            {!! $component->render('panel.default', [ 'param' => 'data.label' ]) !!}
        </div>
    </div>
</div>