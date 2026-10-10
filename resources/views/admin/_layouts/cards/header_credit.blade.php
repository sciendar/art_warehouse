<div class="card-header">
    <div class="row">
        <div class="col align-content-center h6">
            <a href="{{ route($route . '.index') }}" class="mt-1">
                <i class="bi bi-chevron-double-left"></i>
            </a>
            {!! $title !!} | @isset($item) Редагування – {{ Str::limit($item->title_uk, 50, '...') }} @else Створення @endisset
        </div>

        @if(isset($item) && is_array($model::$page_types ?? null))
            <div class="col-auto text-end">
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <a href="{{ route($route . '.edit', $item)  }}" class="btn btn-{{ ($_GET['page_type'] ?? null) == null ? 'primary' : 'outline-primary' }} btn-sm">
                            Основне
                        </a>
                    </div>
                    @foreach($model::$page_types as $page_type => $page_type_title)
                        <div class="col-auto">
                            <a href="{{ route($route . '.edit', [$var=>$item, 'page_type'=>$page_type])  }}" class="btn btn-{{ ($_GET['page_type'] ?? null) == $page_type ? 'primary' : 'outline-primary' }} btn-sm">
                                {{ $page_type_title }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
