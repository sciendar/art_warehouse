<label class="form-label" for="warehouses">
    Склады
</label>
<select class="multiple-select" name="warehouses[]" id="warehouses" data-placeholder="Сделайте выбор" multiple="multiple" @required($required ?? false)>
    @foreach(\App\Helpers\CacheHelper::warehouses() as $warehouse)
        <option value="{{ $warehouse->id }}" @selected(isset($item) && $item->warehouses->contains($warehouse->id))>{{ $warehouse->title }} ({{ $warehouse->country_title }})</option>
    @endforeach
</select>
