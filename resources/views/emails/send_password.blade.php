@extends('emails._layout')

@section('content')
    <p style="font-family: 'Poppins', -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol;
		color: #000;
		font-size: 22px;
		font-style: italic;
		font-weight: 400;
		line-height: normal;">
        Пароль для входа на skladart.eu <b>{{ $user->visible_password }}</b>
    </p>
@endsection
