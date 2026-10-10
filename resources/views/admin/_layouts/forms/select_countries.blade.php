<label class="form-label" for="country_id">
    Страна
</label>
<select class="single-select" name="country_id" id="country_id" data-select2-id="country_id" tabindex="-1" aria-hidden="true" required>
    <option value="" selected disabled>Сделайте выбор</option>
    @foreach(\App\Helpers\CacheHelper::countries() as $country)
        <option value="{{ $country->id }}" @if((isset($item) && $item->country_id == $country->id) || (old('country_id') == $country->id)) selected @endif>{{ $country->title }}</option>
    @endforeach
</select>
