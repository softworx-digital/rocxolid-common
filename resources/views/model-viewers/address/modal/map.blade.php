<div id="{{ $component->getDomId('modal-map') }}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ajax-overlay">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">{{ $component->translate('model.title.singular') }} <small>{{ $component->getModel()->street_name }} {{ $component->getModel()->street_no }}, {{ $component->getModel()->city->getTitle() }}, {{ $component->getModel()->country->getTitle() }}</small></h4>
            </div>
            <div class="modal-body">
                <iframe src="http://maps.google.com/maps?q={{ $component->getModel()->latitude }},{{ $component->getModel()->longitude }}&hl={{ $user->profile ? $user->profile->language->iso_639_1 : config('app.locale') }}&z=14&amp;output=embed" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" class="mapa"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.close') }}</button>
            </div>
        </div>
    </div>
</div>