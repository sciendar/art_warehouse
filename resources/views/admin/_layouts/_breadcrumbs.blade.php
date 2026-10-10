<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.home') }}" data-bs-toggle="tooltip" data-bs-html="true" title="Главная">
                        <i class="bx bx-home-alt"></i>
                    </a>
                </li>
                @if(Route::is('*.index'))
                    <li class="breadcrumb-item active" aria-current="page">
                        {!! $icon !!}  {{ $title }}
                    </li>
                @else
                    <li class="breadcrumb-item">
                        <a href="{{ route($route . '.index') }}" data-bs-toggle="tooltip" data-bs-html="true" title="{{ $title }}">
                            {!! $icon !!} {{ $title }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ isset($item) ? 'Редактирование' : 'Создание' }}
                    </li>
                @endif
            </ol>
        </nav>
    </div>

    @if(($is_add ?? true) && Route::is('*.index'))
        <div class="ms-auto">
            <a href="{{ route($route . '.create') }}" class="btn btn-outline-primary">
                Добавить
            </a>
        </div>
    @endif

    @if(auth()->user()->is_admin() && Route::is('*.edit'))
        <div class="ms-auto">
            <a href="#" class="text-danger mx-3" data-tooltip="tooltip" title="Remove" data-bs-toggle="modal" data-bs-target="#delete">
                <i class="bi bi-trash3"></i>
            </a>
        </div>
        <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="delete_label" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <form action="{{ route($route . '.destroy', $item) }}" class="was-validated" id="destroy" method="POST">
                        @method('DELETE')
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title" id="delete_label">Удаление</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col text-danger">
                                    Точно удалить?
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-end">
                            <button type="submit" class="btn btn-primary confirm-selection">Удалить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
