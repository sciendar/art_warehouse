@extends('emails._layout')

@section('content')
    {!! config('app.name') !!}
    <hr>
    <br>
    {!! $message !!}
@endsection
