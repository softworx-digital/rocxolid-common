@extends('rocXolid::layouts.default')

@section('content')

{!! $component->render('include.commander', [ 'assignments' => $assignments ]) !!}
{!! $component->render('include.output', [ 'assignments' => $assignments ]) !!}

@endsection