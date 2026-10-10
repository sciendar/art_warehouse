@extends('admin._layout')

@section('title', 'Мультиязычность')



@section('content')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
{{--        <div class="breadcrumb-title pe-3">Tables</div>--}}
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.home') }}" data-bs-toggle="tooltip" title="Главная">
                            <i class="bx bx-home-alt"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <i class="bi bi-translate"></i> Текст писем
                    </li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal__credit">
                Добавить
            </button>
            @include('admin.emails._modal_credit')
        </div>
    </div>
    <!--end breadcrumb-->
    <hr/>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">
                                №
                            </th>
                            <th class="text-center">
                                <i class="bi bi-gear"></i>
                            </th>
                            <th class="text-center">
                                Ключ
                            </th>
                            <th class="text-center">
                                Текст
                            </th>
                            <th class="text-center">
                                Дата
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            @include('admin.emails._index_table')
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-center">
                                №
                            </th>
                            <th class="text-center">
                                <i class="bi bi-gear"></i>
                            </th>
                            <th class="text-center">
                                Ключ
                            </th>
                            <th class="text-center">
                                Текст
                            </th>
                            <th class="text-center">
                                Дата
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <!--plugins-->
    <link href="{{ asset('admin/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
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
    <script src="{{ asset('admin/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/table-datatable.js') }}"></script>

    <!--app-->
    <script src="{{ asset('admin/assets/js/app.js') }}"></script>
@endpush
