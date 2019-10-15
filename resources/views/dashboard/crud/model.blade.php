@extends('rocXolid::layouts.default')

@section('content')
<div class="ajax-overlay">
    {!! $component->getModelViewerComponent()->render($model_viewer_template) !!}
<div class="ajax-overlay">
@endsection