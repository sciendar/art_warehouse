<label class="form-label mb-1">
    Роль
</label>
<select class="single-select" name="role_id" id="role_id" data-select2-id="role_id" tabindex="-1" aria-hidden="true" required>
    <option value="" selected disabled>Сделайте выбор</option>
    @foreach(\App\Helpers\CacheHelper::roles() as $role)
        <option value="{{ $role->id }}" @if($role->id == ($_GET['role_id'] ?? null)) selected @endif>{{ $role->title }}</option>
    @endforeach
</select>
