<div id="{{ $component->getDomId() }}">
    <div class="x_panel ajax-overlay">
        <div class="x_title">
            <div class="row">
                <div class="col-md-8 col-xs-12">
                    <h2 class="text-overflow">
                        {{ $component->translate('text.terminal') }}
                    </h2>
                </div>
            </div>
        </div>
        <div class="x_content">
        {{ Form::open([ 'id' => $component->getDomId('run'), 'url' => route('rocXolid.common.artisan.run') ]) }}
            <div class="row">
                <div class="col-xs-12" data-toggle="buttons">
                @foreach ($assignments->get('controller')->availableCommands() as $command)
                    <label class="btn btn-primary margin-bottom-5" title="{{ $command->getDescription() }}">
                        <input type="radio" name="type" value="{{ get_class($command) }}"> {{ (new \ReflectionClass($command))->getShortName() }}
                    </label>
                @endforeach
                </div>
            </div><hr />
            <div class="row">
                <div class="col-xs-12">
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default {{-- active --}}">
                            <input type="checkbox" name="verbose" {{-- checked="checked" --}} value="1"> Verbose
                        </label>
                        <label class="btn btn-default">
                            <input type="checkbox" name="dry-run" value="1"> Dry run
                        </label>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-success" data-ajax-submit-form="{{ $component->getDomIdHash('run') }}"><i class="fa fa-play margin-right-10"></i>{{ $component->translate('button.run') }}</button>
                    </div>
                </div>
            </div>
        {{ Form::close() }}
        </div>
    </div>
</div>