@extends('admin._layouts._layout')

@section('title', 'Аукционы')

@section('breadcrumb')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        @include('admin._layouts._breadcrumbs')
    </div>
    <hr/>
@endsection

@section('content')
    @yield('breadcrumb')
    @include('admin._includes.locales', ['required' => ['title']])

    <div class="card">
        <form action="{{ isset($item) ? route($route . '.update', $item) : route($route . '.store') }}" class="was-validated" method="POST" enctype="multipart/form-data">
            @isset($item) @method('PATCH') @endisset
            @csrf

            <input type="hidden" name="lang" value="{{ $LANG }}">

            <div class="card-body">
                @if($LANG == $MAIN_LANG)
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="label mb-1">
                                <span class="mx-2">
                                    <i class="bi bi-image"></i>
                                </span>
                                Фото
                            </label>
                        </div>
{{--                        @include('admin._includes.credit_images',['min_photo' =>1])--}}
{{--                        @include('admin._includes.credit_file_images',['label'=>'Фото', 'add'=>true])--}}
                    </div>
                @endif

                <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                <label for="{{ $title }}" class="mb-1">
                                    <i class="flag-icon flag-icon-{{ $LANG }}"></i> Название {{ $LANG }}
                                </label>
                                <input class="form-control mb-3" type="text" name="title" id="title" placeholder="Введите данные" aria-label="default input example" value="{{ $item->title ?? old('title') }}" required>
                            </div>
                            @if($LANG == $MAIN_LANG)
                                <div class="col-md-4">
                                    <label class="form-label mb-1">
                                        <span class="mx-2">
                                            <i class="bi bi-calendar3"></i>
                                        </span>
                                        Дата и время проведения
                                    </label>
                                    <input type="datetime-local" class="result form-control" id="date_time" name="date_time" value="{{ (isset($item) && $item->date_time != null) ? $item->date_time : now()->addWeek() }}"><!-- TODO поправить формат даты -->
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                @include('admin._includes.form.textarea_ckeditor', ['data'=>'description','label'=>'Описание'])
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                @include('admin._includes.form.textarea_ckeditor', ['data'=>'terms','label'=>'Условия'])
                            </div>
                        </div>

                        @if($LANG == $MAIN_LANG)
                            <hr>
                            <div class="row">
                                <div class="col-md mb-3">
                                    <label for="url_invaluable" class="form-label mb-1">
                                        <span class="mx-2">
                                            <i class="bi bi-box-arrow-up-right"></i>
                                        </span>
                                        Ссылка на данный аукцион в <a href="https://www.invaluable.com/" target="_blank">invaluable</a>
                                    </label>
                                    <input class="form-control" type="url" name="url_invaluable" id="url_invaluable" value="{{ $item->url_invaluable ?? old('url_invaluable') }}" placeholder="Введите ссылку">
                                </div>
                                <div class="col-md mb-3">
                                    <label for="url_bidsquare" class="form-label mb-1">
                                        <span class="mx-2">
                                            <i class="bi bi-box-arrow-up-right"></i>
                                        </span>
                                        Ссылка на данный аукцион в <a href="https://www.bidsquare.com/" target="_blank">bidsquare</a>
                                    </label>
                                    <input class="form-control" type="url" name="url_bidsquare" id="url_bidsquare" value="{{ $item->url_bidsquare ?? old('url_bidsquare') }}" placeholder="Введите ссылку">
                                </div>
                                <div class="col-md mb-3">
                                    <label for="url_liveauctioneers" class="form-label mb-1">
                                        <span class="mx-2">
                                            <i class="bi bi-box-arrow-up-right"></i>
                                        </span>
                                        Ссылка на данный аукцион в <a href="https://www.liveauctioneers.com/" target="_blank">liveauctioneers</a>
                                    </label>
                                    <input class="form-control" type="url" name="url_liveauctioneers" id="url_liveauctioneers" value="{{ $item->url_liveauctioneers ?? old('url_liveauctioneers') }}" placeholder="Введите ссылку">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="lots" class="form-label mb-1">
                                        <span class="mx-2">
                                            <i class="bi bi-filetype-xlsx"></i>
                                        </span>
                                        Лоты из файла .xlsx
                                    </label>
                                    <input class="form-control" type="file" name="lots" id="lots" accept=".xlsx, .xls">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="photo_lots" class="form-label mb-1">
                                        <span class="mx-2">
                                            <i class="bi bi-images"></i>
                                        </span>
                                        Фото лотов <span class="text-danger">строго до 200 файлов</span>
                                    </label>
                                    <input class="form-control" type="file" name="photo_lots[]" id="photo_lots" accept="image/*" multiple>
                                </div>
                            </div>
                        @endif
                        @include('admin._includes.form.seo')
                    </div>
                </div>
            </div>
            <div class="modal-footer">
{{--                @if($locale == $MAIN_LANG)--}}
                    <div class="form-check form-switch {{ ($LANG != $MAIN_LANG) ? 'd-none' : '' }}">
                        <input class="form-check-input mx-2" type="checkbox" name="is_active" id="is_active" @if((isset($item) && $item->is_active == true) || !isset($item)) checked @endif style="height: 20px; width: 40px"  data-bs-toggle="tooltip" title="Статус">
                    </div>
{{--                @endif--}}
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </div>
@endsection

{{--@push('styles')--}}
{{--    <!--plugins-->--}}
{{--    <link href="{{ asset('admin/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />--}}
{{--    <link href="{{ asset('admin/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />--}}
{{--    <link href="{{ asset('admin/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />--}}
{{--    <!-- Bootstrap CSS -->--}}
{{--    <link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" />--}}
{{--    <link href="{{ asset('admin/assets/css/bootstrap-extended.css') }}" rel="stylesheet" />--}}
{{--    <link href="{{ asset('admin/assets/css/style.css') }}" rel="stylesheet" />--}}
{{--    <link href="{{ asset('admin/assets/css/icons.css') }}" rel="stylesheet">--}}
{{--    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">--}}
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">--}}

{{--    <!-- loader-->--}}
{{--    <link href="{{ asset('admin/assets/css/pace.min.css" rel="stylesheet') }}" />--}}

{{--    <!--Theme Styles-->--}}
{{--    <link href="{{ asset('admin/assets/css/dark-theme.css') }}" rel="stylesheet" />--}}
{{--    <link href="{{ asset('admin/assets/css/light-theme.css') }}" rel="stylesheet" />--}}
{{--    <link href="{{ asset('admin/assets/css/semi-dark.css') }}" rel="stylesheet" />--}}
{{--    <link href="{{ asset('admin/assets/css/header-colors.css') }}" rel="stylesheet" />--}}
{{--@endpush--}}

{{--@push('scripts')--}}
{{--    <!-- Bootstrap bundle JS -->--}}
{{--    <script src="{{ asset('admin.assets/js/bootstrap.bundle.min.js') }}"></script>--}}
{{--    <!--plugins-->--}}
{{--    <script src="{{ asset('admin/assets/js/jquery.min.js') }}"></script>--}}
{{--    <script src="{{ asset('admin/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>--}}
{{--    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>--}}
{{--    <script src="{{ asset('admin/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>--}}
{{--    <script src="{{ asset('admin/assets/js/pace.min.js') }}"></script>--}}

{{--    <!--app-->--}}
{{--    <script src="{{ asset('admin/assets/js/app.js') }}"></script>--}}
{{--    <script>--}}
{{--        $(function() {--}}
{{--            "use strict";--}}

{{--            $('.datepicker').pickadate({--}}
{{--                selectMonths: true,--}}
{{--                selectYears: true--}}
{{--            }),--}}
{{--                $('.timepicker').pickatime()--}}



{{--            $('#date-time').bootstrapMaterialDatePicker({--}}
{{--                format: 'YYYY-MM-DD HH:mm'--}}
{{--            });--}}
{{--            $('#date').bootstrapMaterialDatePicker({--}}
{{--                time: false--}}
{{--            });--}}
{{--            $('#time').bootstrapMaterialDatePicker({--}}
{{--                date: false,--}}
{{--                format: 'HH:mm'--}}
{{--            });--}}



{{--        });--}}
{{--    </script>--}}
{{--@endpush--}}
