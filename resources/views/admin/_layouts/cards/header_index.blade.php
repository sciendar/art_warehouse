<div class="card-header">
    <div class="row">
        <div class="col">
            <h5 class="mt-1">
                <span class="mx-2">{!! $title !!}</span>
            </h5>
        </div>
        <div class="col text-end">
            @if(!isset($is_add) || $is_add != false)
                <a href="{{ route($model::route(suffix: 'create')) }}" class="btn btn-outline-primary btn-sm">
                    Додати
                </a>
            @endif
        </div>
    </div>
</div>
