@extends('rocXolid::layouts.default')

@section('content')
<div class="ajax-overlay">
    {!! $component->getRepositoryComponent()->render() !!}
</div>
@endsection