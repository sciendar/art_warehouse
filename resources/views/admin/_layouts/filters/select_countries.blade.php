<label class="form-label mb-1">
    Страна
</label>
<select class="single-select" name="country_id" id="country_id" data-select2-id="country_id" tabindex="-1" aria-hidden="true" required>
    <option value="" selected disabled>Сделайте выбор</option>
    @foreach(\App\Helpers\CacheHelper::countries() as $country)
        <option value="{{ $country->id }}" @if($country->id == ($_GET['country_id'] ?? null)) selected @endif>{{ $country->title }}</option>
    @endforeach
</select>
