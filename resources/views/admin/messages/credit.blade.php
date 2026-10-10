@extends('admin._layouts._layout')

@section('title', 'Аукционы')

@section('breadcrumb')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        @include('admin._layouts._breadcrumbs')
        <div class="ms-auto">
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal_bulk_add">
                Загрузить из файла
            </button>
            @include('admin.lots._modal_bulk_add')
        </div>
    </div>
    <hr/>
@endsection

@section('content')
    @yield('breadcrumb')
    @include('admin._includes.locales')
    @php
        $locale = isset($_GET['lang']) && in_array($_GET['lang'], array_keys(config('app.locales')))
            ? $_GET['lang']
            : config('app.locale');
        $title = 'title_' . $locale;
        $description = 'description_' . $locale;
        $terms = 'terms_' . $locale;
    @endphp
    <div class="card">
        <form action="{{ isset($item) ? route($route . '.update',$item) : route($route . '.store') }}" class="was-validated" method="POST" enctype="multipart/form-data">
            @isset($item) @method('PATCH') @endisset
            @csrf

            <div class="card-body">

                @if($locale == config('app.locale'))
                    <div class="row mb-3">
                        @include('admin._includes.credit_images',['label'=>'Фото','max_photo'=>20, 'add_photo'=>true])
                    </div>

                    <div class="row">
                        <div class="col-md mb-3">
                            <label class="form-label mb-1">
                                <span class="mx-2">
                                    <i class="bi bi-person-workspace"></i>
                                </span>
                                Аукцион
                            </label>
                            <select class="single-select" name="auction_id" id="auction_id" data-select2-id="auction_id" tabindex="-1" aria-hidden="true" required>
                                <option value="" selected disabled>Сделайте выбор</option>
                                @foreach($auctions as $auction)
                                    <option value="{{ $auction->id }}" @if(isset($item) && $item->auction_id == $auction->id) selected @endif>{{ $auction->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md mb-3">
                            <label class="form-label mb-1">
                                <span class="mx-2">
                                    <i class="bi bi-person-bounding-box"></i>
                                </span>
                                Автор
                            </label>
                            <select class="single-select" name="author_id" id="author_id" data-select2-id="author_id" tabindex="-1" aria-hidden="true" required>
                                <option value="" selected disabled>Сделайте выбор</option>
                                @foreach($authors as $author)
                                    <option value="{{ $author->id }}" @if(isset($item) && $item->author_id == $author->id) selected @endif>{{ $author->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md mb-3">
                            <label class="form-label mb-1">
                                <span class="mx-2">
                                    <i class="bi bi-patch-exclamation"></i>
                                </span>
                                Состояние
                            </label>
                            <select class="single-select" name="condition_id" id="condition_id" data-select2-id="condition_id" tabindex="-1" aria-hidden="true" required>
                                <option value="" selected disabled>Сделайте выбор</option>
                                @foreach($conditions as $condition)
                                    <option value="{{ $condition->id }}" @if(isset($item) && $item->condition_id == $condition->id) selected @endif>{{ $condition->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md mb-3">
                            <label class="form-label mb-1">
                                <span class="mx-2">
                                    <i class="bi bi-sort-numeric-down"></i>
                                </span>
                                Номер лота
                            </label>
                            <input class="form-control mb-3" type="number" name="lot" id="lot" placeholder="Введите данные" aria-label="default input example" min="0" step="1" value="{{ $item->lot ?? old('lot') }}" required>
                        </div>

                        <div class="col-md mb-3">
                            <label class="form-label mb-1">
                                <span class="mx-2">
                                    <i class="bi bi-cash-coin"></i>
                                </span>
                                Стартовая цена
                            </label>
                            <input class="form-control mb-3" type="number" name="start_price" id="start_price" placeholder="Введите данные" aria-label="default input example" min="0" step="1" value="{{ $item->start_price ?? old('start_price') }}" required>
                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="col">
                        <label for="{{ $title }}" class="mb-1">
                            <img src="{{ asset('admin/assets/images/flag_' . $locale . '.png') }}" class="mx-2" width="18px" alt=""> Название {{ $locale }}
                        </label>
                        <input class="form-control mb-3" type="text" name="{{ $title }}" id="{{ $title }}" placeholder="Введите данные" aria-label="default input example" value="{{ $item->$title ?? old($title) }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="{{ $description }}" class="mb-1">
                            <img src="{{ asset('admin/assets/images/flag_' . $locale . '.png') }}" class="mx-2" width="18px" alt=""> Описание {{ $locale }}
                            <strong class="text-primary mx-2" data-bs-toggle="tooltip" title="Данное поле поддерживает HTML-теги">
                                <i class="bi bi-code-square"></i>
                            </strong>
                        </label>
                        @include('admin._includes.form.textarea_ckeditor', ['data' => $description])
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                @if($locale == 'en')
                    <div class="form-check form-switch">
                        <input class="form-check-input mx-2" type="checkbox" name="is_active" id="is_active" @if((isset($item) && $item->is_active == true) || !isset($item)) checked @endif style="height: 20px; width: 40px"  data-bs-toggle="tooltip" title="Статус">
                    </div>
                @endif
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('admin/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('admin/assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/form-select2.js') }}"></script>
@endpush
