@extends('emails._layout_admin')

@section('content')
    <p style="font-family: 'Poppins', -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol;
		color: #000;
		font-size: 22px;
		font-style: italic;
		font-weight: 400;
		line-height: normal;">
        Создана новая подписка
    </p>
    <p style="font-family: 'Poppins', -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol;
		color: #000;
		font-size: 22px;
		font-style: italic;
		font-weight: 400;
		line-height: normal;">
        id: {{ $subscription->id }}
    </p>
    <p style="font-family: 'Poppins', -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol;
		color: #000;
		font-size: 22px;
		font-style: italic;
		font-weight: 400;
		line-height: normal;">
        email: <a href="mailto:{{ $subscription->email }}">
            {{ $subscription->email }}
        </a>
    </p>
@endsection
