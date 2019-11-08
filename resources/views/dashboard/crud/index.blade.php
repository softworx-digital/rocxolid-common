@extends('rocXolid::layouts.default')

@section('content')

{!! $component->getRepositoryComponent()->render() !!}

@endsection