<form action="{{ route($route . '.index') }}" method="GET">
    <div class="row">
        <div class="col-md">
            @include('admin._layouts.forms.input', ['data'=>'title','label'=>'Название <span class="text-primary mx-1" data-bs-toggle="tooltip" title="Поиск по части"><i class="bi bi-search"></i></span>','value'=>($_GET['title'] ?? null)])
        </div>

        <div class="col-md">
            @include('admin._layouts.filters.select_countries')
        </div>

        @include('admin._layouts.filters.actions')
    </div>
</form>
