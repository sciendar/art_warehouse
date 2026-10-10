@extends('admin._layouts._layout')

@section('title', 'error 403')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col text-center">
                    <img src="{{ asset('admin/assets/images/error/error_403.gif') }}" alt="">
                </div>
            </div>
        </div>
    </div>
@endsection
