@extends('admin._layout')

@section('title', 'FAQs')

@section('breadcrumb')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        @include('admin._layouts._breadcrumbs')
    </div>
    <hr/>
@endsection

@section('content')
    @yield('breadcrumb')
    @include('admin._includes.locales', ['required' => ['title', 'description']])

    <div class="card">
        <form action="{{ isset($item) ? route($route . '.update', $item) : route($route . '.store') }}" class="was-validated" method="POST" enctype="multipart/form-data">
            @isset($item) @method('PATCH') @endisset
            @csrf

            <input type="hidden" name="lang" value="{{ $locale }}">

            <div class="card-body">
                <div class="row">
{{--                    @include('admin._include.credit_images',['label'=>'Фото','min_photo'=>1])--}}
{{--                    @include('admin._include.credit_file_images',['label'=>'Фото'])--}}
                    <div class="col">
                        <label for="{{ $title }}" class="mb-1">
                            <img src="{{ asset('admin/assets/images/flag_' . $locale . '.png') }}" class="mx-2" width="18px" alt=""> ФИО {{ $locale }}
                        </label>
                        <input class="form-control mb-3" type="text" name="{{ $title }}" id="{{ $title }}" placeholder="Введите данные" aria-label="default input example" value="{{ $item->$title ?? old($title) }}" required>

                        <label for="{{ $description }}" class="mb-1">
                            <img src="{{ asset('admin/assets/images/flag_' . $locale . '.png') }}" class="mx-2" width="18px" alt=""> Описание {{ $locale }}
                            <strong class="text-primary mx-2" data-bs-toggle="tooltip" title="Данное поле поддерживает HTML-теги">
                                <i class="bi bi-code-square"></i>
                            </strong>
                        </label>
                        <textarea class="form-control  mb-3" type="text" name="{{ $description }}" id="{{ $description }}" placeholder="Введите данные" aria-label="default input example" maxlength="2500" required>{{ $item->$description ?? old($description) }}</textarea>
                    </div>
                </div>
                @include('admin._include.form.seo')
            </div>
            <div class="modal-footer">
                @if($locale == config('app.locale'))
                    <div class="form-check form-switch">
                        <input class="form-check-input mx-2" type="checkbox" name="status" id="status" @if((isset($item) && $item->status == true) || !isset($item)) checked @endif style="height: 20px; width: 40px"  data-bs-toggle="tooltip" title="Статус">
                    </div>
                @endif
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <!--plugins-->
    <link href="{{ asset('admin/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/css/bootstrap-extended.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/css/icons.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- loader-->
    <link href="{{ asset('admin/assets/css/pace.min.css" rel="stylesheet') }}" />

    <!--Theme Styles-->
    <link href="{{ asset('admin/assets/css/dark-theme.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/css/light-theme.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/css/semi-dark.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/css/header-colors.css') }}" rel="stylesheet" />
@endpush

@push('scripts')
    <!-- Bootstrap bundle JS -->
    <script src="{{ asset('admin.assets/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    <script src="{{ asset('admin/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('admin/assets/js/pace.min.js') }}"></script>

    <!--app-->
    <script src="{{ asset('admin/assets/js/app.js') }}"></script>

    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    <script>
        {{--CKEDITOR.replace({{ Str::remove('[]', $data) . $rand }} , {--}}
        {{--    allowedContent: true--}}
        {{--} );--}}
        $(".CKEDITOR").each(function () {
            let id = $(this).attr('id');
            CKEDITOR.replace(id, {
                allowedContent: true
            });
        });
    </script>
@endpush
