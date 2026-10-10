<form action="{{ route($route . '.index', ['locale'=>app()->getLocale()]) }}" method="GET">
    <div class="row">
        <div class="col-md">
            @include('admin._layouts.forms.input', ['data'=>'url','label'=>'Сторінка <span class="text-primary mx-1" data-bs-toggle="tooltip" title="Пошук за частиною"><i class="bi bi-search"></i></span>','value'=>($_GET['url'] ?? null)])
        </div>
        <div class="col-md">
            <label class="form-label mb-2" for="status_code">
                Код відповіді
            </label>
            <select class="single-select" name="status_code" id="status_code" data-select2-id="status_code" tabindex="-1">
                <option value="" selected>Зробіть вибір</option>
                @foreach($status_codes as $status_code)
                    <option value="{{ $status_code }}" @if(($_GET['status_code'] ?? null) == $status_code) selected @endif>{{ $status_code }}</option>
                @endforeach
            </select>
        </div>
{{--        <div class="col-md">--}}
{{--            <label class="form-label mb-2" for="country">--}}
{{--                Країна--}}
{{--            </label>--}}
{{--            <select class="single-select" name="country" id="country" data-select2-id="country" tabindex="-1">--}}
{{--                <option value="" selected>Зробіть вибір</option>--}}
{{--                @foreach($countries as $country)--}}
{{--                    <option value="{{ $country }}" @if(($_GET['country'] ?? null) == $country) selected @endif>{{ $country }}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </div>--}}
        <div class="col-md-auto">
            @include('admin._layouts.forms.input', ['data'=>'created_at','type'=>'date','label'=>'Дата','value'=>($_GET['created_at'] ?? null)])
        </div>

        @include('admin._layouts.filters.actions')
    </div>
</form>
