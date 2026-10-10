@extends('web._layout')

@section('title', 'Login')

@section('content')
    <div class="container-xxl mt-5 mb-3">
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal_sing_up" type="button">{!! trans('trans.sing_up') !!}</button>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('dist/css/pages/page-home.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('dist/js/pages/page-home.js') }}"></script>
    <script>
        let myModal = new bootstrap.Modal(document.getElementById('modal_sing_up'), {
            // keyboard: false
        });
        myModal.show();
    </script>
@endpush

