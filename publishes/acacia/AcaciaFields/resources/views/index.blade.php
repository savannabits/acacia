@extends('fields::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from acacia: {!! config('fields.name') !!}
    </p>
@endsection
