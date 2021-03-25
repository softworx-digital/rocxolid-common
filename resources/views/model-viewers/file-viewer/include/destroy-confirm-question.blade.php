<p class="text-center">{{ $component->translate('text.destroy-confirmation') }} {{ Str::lower($component->translate('model.title.singular')) }}?</p>
<div class="row">
    <div class="col-md-4 col-md-offset-4 col-xs-12">{{ $component->render('default', [ 'file' => $component->getModel() ]) }}</div>
</div>