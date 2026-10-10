<label class="form-label" for="warehouse_id">
    Склад
</label>
<select class="single-select" name="warehouse_id" id="warehouse_id" data-select2-id="warehouse_id" tabindex="-1" aria-hidden="true" @required($required ?? false) @disabled($disabled ?? false) @readonly($readonly ?? false)>
    <option value="" selected disabled>Сделайте выбор</option>
    @foreach(\App\Helpers\CacheHelper::warehouses() as $warehouse)
        <option value="{{ $warehouse->id }}" @selected((isset($item) && $item->warehouse_id == $warehouse->id) || (old('warehouse_id') == $warehouse->id))>{{ $warehouse->title }} ({{ $warehouse->country_title }})</option>
    @endforeach
</select>
