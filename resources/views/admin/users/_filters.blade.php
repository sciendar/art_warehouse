<form action="{{ route($route . '.index') }}" method="GET">
    <div class="row">
        <div class="col-md">
            @include('admin._layouts.forms.input', ['data'=>'name','label'=>'ФИО <span class="text-primary mx-1" data-bs-toggle="tooltip" title="Поиск по части"><i class="bi bi-search"></i></span>','value'=>($_GET['name'] ?? null)])
        </div>
        <div class="col-md">
            @include('admin._layouts.forms.input', ['data'=>'email','label'=>'Емейл <span class="text-primary mx-1" data-bs-toggle="tooltip" title="Поиск по части"><i class="bi bi-search"></i></span>','value'=>($_GET['email'] ?? null)])
        </div>
        <div class="col-md">
            @include('admin._layouts.filters.select_warehouses')
        </div>

        @include('admin._layouts.filters.actions')
    </div>
</form>
