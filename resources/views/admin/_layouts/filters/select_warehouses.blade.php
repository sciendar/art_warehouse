<label class="form-label mb-1" for="warehouse_id">
    Склад
</label>
<select class="single-select" name="warehouse_id" id="warehouse_id" data-select2-id="warehouse_id" tabindex="-1" aria-hidden="true" @required($required ?? false)>
    <option value="" selected disabled>Сделайте выбор</option>
    @foreach(\App\Helpers\CacheHelper::warehouses() as $warehouse)
        <option value="{{ $warehouse->id }}" @if($warehouse->id == ($_GET['warehouse_id'] ?? null)) selected @endif>{{ $warehouse->title }} ({{ $warehouse->country_title }})</option>
    @endforeach
</select>
